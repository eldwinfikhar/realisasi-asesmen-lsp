<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AssessmentTarget;
use App\Models\Entity;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;


class ImportAssessmentTargets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:assessment-targets {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Impor target asesmen dari sebuah file Excel ke database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Mengambil argumen 'file' yang kita berikan di terminal.
        $filePath = $this->argument('file');
        try {
            // 2. Membuat import sederhana menggunakan ToCollection.
             $import = new class implements ToCollection {
                public $collection;
                public function collection(Collection $collection)
                {
                    $this->collection = $collection;
                }
            };

            // 3. Menggunakan package Maatwebsite Excel untuk membaca file.
            Excel::import($import, $filePath);
            $data = $import->collection;

            // 4. Menghapus baris pertama (header) dari data.
            $rows = $data->slice(1);

            // 5. Memberi pesan informasi ke terminal bahwa proses akan dimulai.
            $this->info('Memulai proses impor untuk ' . $rows->count() . ' baris data target asesmen...');

            // 6. Membuat progress bar yang keren di terminal.
            $bar = $this->output->createProgressBar($rows->count());
            $bar->start();

            foreach ($rows as $row) {
                // 7. Ambil semua field tabel dari excel
                $year        = trim($row[0]);
                $month       = trim($row[1]);
                $targetCount = trim($row[2]);
                $location    = trim($row[3]);
                $entityName  = trim($row[4]);
                
                if (!empty($entityName)) {
                    // 8. Cari di tabel 'entities', entitas yang namanya cocok (untuk target internal)
                    $entity = Entity::where('name', $entityName)->first();
                    if (!$entity) {
                        $this->warn("\nMelewati baris dengan entitas '{$entityName}' karena tidak ditemukan di database.");
                        $bar->advance();
                        continue;
                    }
                    AssessmentTarget::updateOrCreate(
                        [
                            'year'      => $year,
                            'month'     => $month,
                            'entity_id' => $entity->id,
                        ],
                        [
                            'target_count' => $targetCount,
                            'location' => null, // location null untuk target internal
                        ]
                    );
                } else {
                    // 9. Target eksternal langsung simpan data
                    AssessmentTarget::updateOrCreate(
                        [
                            'year'     => $year,
                            'month'    => $month,
                            'location' => $location,
                        ],
                        [                            
                            'target_count' => $targetCount,
                            'entity_id' => null, // entity_id null untuk target eksternal
                        ]
                    );
                }

                $bar->advance();
            }

            // 10. Menyelesaikan progress bar dan memberi pesan sukses.
            $bar->finish();
            $this->info("\n\nImpor data target asesmen berhasil diselesaikan!");

        } catch (\Exception $e) {
            // 11. Jika terjadi error di dalam blok 'try', proses akan ditangkap di sini.
            $this->error("\n\nTerjadi error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
