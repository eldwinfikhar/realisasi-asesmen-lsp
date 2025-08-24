<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Assessee;
use App\Models\Entity;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;


class ImportAssessees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:assessees {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Impor asesi dari sebuah file Excel ke database';

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
            $this->info('Memulai proses impor untuk ' . $rows->count() . ' baris data asesi...');

            // 6. Membuat progress bar yang keren di terminal.
            $bar = $this->output->createProgressBar($rows->count());
            $bar->start();

            $i = 1;
            foreach ($rows as $row) {
                // 7. Ambil semua field tabel dari excel
                $assesseeName = trim($row[0]);
                $band         = trim($row[1]);
                $assesseeType = trim($row[2]);
                $location     = trim($row[3]);
                $entityName   = trim($row[4]);

                if (!is_null($location)) {
                    if ($location === 'Kab. Bandung' || $location === 'Kota Bandung' || $location === 'Kab. Bandung Barat') {
                        $location = "Bandung";
                    } else {
                        $location = "Jakarta";
                    }
                }

                
                // 8. Cari di tabel 'entities', entitas yang namanya cocok.
                $entity = Entity::where('name', $entityName)->first();
                if (!$entity) {
                    $this->warn("\nLewati asesi '{$assesseeName}', entitas '{$entityName}' tidak ditemukan di database.");
                    $bar->advance();
                    continue;
                }

                // 9. Proses create/update dengan 2 ternary operator.
                Assessee::updateOrCreate(
                    [
                        'name' => $assesseeName,
                    ],
                    [
                        'assessee_type' => $assesseeType,
                        'entity_id'     => $entity->id,
                        'band'          => !empty($band) ? $band : null,
                        'location'      => !empty($location) ? $location : null,
                    ]
                );
                
                $bar->advance();
                $i++;
            }

            // 10. Menyelesaikan progress bar dan memberi pesan sukses.
            $bar->finish();
            $this->info("\n\nImpor data asesi berhasil diselesaikan!");

        } catch (\Exception $e) {
            // 11. Jika terjadi error di dalam blok 'try', proses akan ditangkap di sini.
            $this->error("\n\nTerjadi error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
