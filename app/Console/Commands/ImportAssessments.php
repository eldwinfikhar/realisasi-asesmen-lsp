<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Assessee;
use App\Models\Assessment;
use App\Models\Assessor;
use App\Models\Scheme;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;


class ImportAssessments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:assessments {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Impor asesmen dari sebuah file Excel ke database';

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
            $this->info('Memulai proses impor untuk ' . $rows->count() . ' baris data asesmen...');

            // 6. Membuat progress bar yang keren di terminal.
            $bar = $this->output->createProgressBar($rows->count());
            $bar->start();

            $i = 1;
            foreach ($rows as $row) {
                // 7. Ambil semua field tabel dari excel
                $assesseeName       = trim($row[0]);
                $assessorName       = trim($row[1]);
                $schemeName         = trim($row[2]);
                $preAssessmentDate  = trim($row[3]);
                $preAssessmentVenue = trim($row[4]);
                $assessmentDate     = trim($row[5]);
                $assessmentVenue    = trim($row[6]);
                $notes              = trim($row[7]);

                // 8. Cari di tabel 'entities', entitas yang namanya cocok.
                $assessee = Assessee::where('name', $assesseeName)->first();
                $assessor = Assessor::where('name', $assessorName)->first();
                $scheme = Scheme::where('name', $schemeName)->first();
                if (!$assessee) {
                    $this->warn("\nLewati baris, Asesi '{$assesseeName}' tidak ditemukan.");
                    $bar->advance(); continue;
                }
                if (!$assessor) {
                    $this->warn("\nLewati baris, Asesor '{$assessorName}' tidak ditemukan.");
                    $bar->advance(); continue;
                }
                if (!$scheme) {
                    $this->warn("\nLewati baris ke-{$i}, Skema '{$schemeName}' tidak ditemukan.");
                    $bar->advance(); continue;
                }

                try {
                    if (is_numeric($preAssessmentDate)) {
                        $dateObject = Date::excelToDateTimeObject($preAssessmentDate);
                        $parsedPreAssessmentDate = $dateObject->format('Y-m-d');
                    } elseif (!empty($preAssessmentDate)) {
                        $parsedPreAssessmentDate = Carbon::createFromFormat('d/m/Y', $preAssessmentDate)->toDateString();
                    }
                    if (is_numeric($assessmentDate)) {
                        $dateObject = Date::excelToDateTimeObject($assessmentDate);
                        $parsedAssessmentDate = $dateObject->format('Y-m-d');
                    } elseif (!empty($assessmentDate)) {
                        $parsedAssessmentDate = Carbon::createFromFormat('d/m/Y', $assessmentDate)->toDateString();
                    }
                } catch (\Exception $e) {
                    $this->warn("\nLewati baris ke-{$i} untuk Asesi '{$assesseeName}', format tanggal salah.");
                    dd($assesseeName, $assessmentDate, $preAssessmentDate);
                    $bar->advance(); continue;
                }                

                // 9. Proses create/update dengan 2 ternary operator.
                Assessment::updateOrCreate(
                    [
                        'assessee_id'     => $assessee->id,
                        'assessor_id'     => $assessor->id,
                        'scheme_id'       => $scheme->id,
                        'assessment_date' => $parsedAssessmentDate,
                    ],
                    [
                        'pre_assessment_date'  => $parsedPreAssessmentDate,
                        'pre_assessment_venue' => $preAssessmentVenue,
                        'assessment_venue'     => $assessmentVenue,
                        'notes'                => $notes,
                    ]
                );
                
                $i++;
                $bar->advance();
            }

            // 10. Menyelesaikan progress bar dan memberi pesan sukses.
            $bar->finish();
            $this->info("\n\nImpor data asesmen berhasil diselesaikan!");

        } catch (\Exception $e) {
            // 11. Jika terjadi error di dalam blok 'try', proses akan ditangkap di sini.
            $this->error("\n\nTerjadi error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
