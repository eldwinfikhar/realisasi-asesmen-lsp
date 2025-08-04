<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assessment;
use App\Models\Assessee;
use App\Models\Assessor;
use App\Models\Scheme;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ambil semua data master yang diperlukan
        $assessees = Assessee::all();
        $assessors = Assessor::all();
        $schemes = Scheme::all();

        // Pastikan ada data master sebelum melanjutkan
        if ($assessees->isEmpty() || $assessors->isEmpty() || $schemes->isEmpty()) {
            $this->command->info('Please seed the master tables (Assessees, Assessors, Schemes) first.');
            return;
        }

        // 2. Loop untuk setiap asesi
        foreach ($assessees as $assessee) {
            
            // 3. Buat SATU data asesmen untuk asesi ini
            $year = now()->year;
            $assessmentDate = fake()->dateTimeBetween($year.'-01-01', $year.'-12-31');

            Assessment::create([
                'assessee_id' => $assessee->id,
                'assessor_id' => $assessors->random()->id, // Pilih asesor acak
                'scheme_id' => $schemes->random()->id,     // Pilih skema acak
                'pre_assessment_date' => fake()->dateTimeBetween($year.'-01-01', $assessmentDate),
                'assessment_date' => $assessmentDate,
                'pre_assessment_venue' => fake()->city(),
                'assessment_venue' => fake()->city(),
                'notes' => fake()->sentence(),
            ]);
        }
    }
}