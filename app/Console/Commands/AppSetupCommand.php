<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AppSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup {--fresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Siapkan aplikasi dengan data awal: menjalankan migrasi, menyemai, dan mengimpor semua file Excel.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses setup aplikasi lengkap...');
        $this->newLine();

        // Cek apakah pengguna memberikan flag --fresh
        if ($this->option('fresh')) {
            $this->comment('Menjalankan migrate:fresh dan seeder...');
            Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
        } else {
            $this->comment('Menjalankan migrate dan seeder...');
            Artisan::call('migrate', ['--seed' => true, '--force' => true]);
        }
        $this->info('Migrasi & Seeder selesai.');
        $this->newLine();

        $this->comment('Memulai proses impor dari file Excel...');

        // Definisikan daftar file impor dan command-nya sesuai urutan
        $imports = [
            'entities'           => 'storage/app/data-entities.xlsx',
            'schemes'            => 'storage/app/data-schemes.xlsx',
            'assessors'          => 'storage/app/data-assessors.xlsx',
            'assessees'          => 'storage/app/data-assessees.xlsx',
            'assessment-targets' => 'storage/app/data-assessment-targets.xlsx',
            'assessments'        => 'storage/app/data-assessments.xlsx',
        ];

        // Buat progress bar untuk proses impor
        $bar = $this->output->createProgressBar(count($imports));
        $bar->start();

        foreach ($imports as $commandName => $filePath) {
            // Cek apakah file Excel-nya ada sebelum menjalankan command
            if (!file_exists(base_path($filePath))) {
                $this->warn("\nFile {$filePath} tidak ditemukan, proses impor untuk data ini dilewati.");
                $bar->advance();
                continue; // Lanjut ke file berikutnya
            }

            // Memanggil command import yang sudah kita buat
            $this->line("\n Mengimpor {$commandName}...");
            Artisan::call("import:{$commandName}", ['file' => $filePath]);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info('>>> Setup aplikasi berhasil diselesaikan! <<<');

        return 0;
    }
}