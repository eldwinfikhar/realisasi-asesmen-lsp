<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Entity;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;


class ImportEntities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:entities {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Impor entitas dari sebuah file Excel ke database';

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
            $this->info('Memulai proses impor untuk ' . $rows->count() . ' baris data entitas...');

            // 6. Membuat progress bar yang keren di terminal.
            $bar = $this->output->createProgressBar($rows->count());
            $bar->start();

            // 7. Melakukan perulangan (loop) untuk setiap baris data yang kita dapat dari Excel.
            foreach ($rows as $row) {

                // 8. $row[0] berarti kita mengambil data dari kolom pertama (Kolom A) di Excel.
                Entity::updateOrCreate(
                    ['name' => $row[0]], // Kolom unik untuk dicari
                    ['name' => $row[0]]  // Data untuk diisi atau di-update
                );

                // 9. Memajukan progress bar satu langkah.
                $bar->advance();
            }

            // 10. Menyelesaikan progress bar dan memberi pesan sukses.
            $bar->finish();
            $this->info("\n\nImpor data entitas berhasil diselesaikan!");

        } catch (\Exception $e) {
            // 11. Jika terjadi error di dalam blok 'try', proses akan ditangkap di sini.
            $this->error("\n\nTerjadi error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
