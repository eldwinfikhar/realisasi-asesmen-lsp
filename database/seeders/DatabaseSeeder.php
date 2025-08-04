<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder order:
        // 1. EntitySeeder: creates entities needed by assessees and assessment targets
        // 2. AssesseeSeeder: needs entities
        // 3. AssessorSeeder: independent
        // 4. SchemeSeeder: independent
        // 5. AssessmentTargetSeeder: needs entities
        // 6. AssessmentSeeder: needs assessees, assessors, schemes
        $this->call([
            UserSeeder::class,
            EntitySeeder::class,
            AssesseeSeeder::class,
            AssessorSeeder::class,
            SchemeSeeder::class,
            AssessmentTargetSeeder::class,
            AssessmentSeeder::class,
        ]);
    }
}
