<?php

namespace Database\Seeders;

use App\Models\Assessor;
use Illuminate\Database\Seeder;

class AssessorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Assessor::factory(120)->create();
    }
}
