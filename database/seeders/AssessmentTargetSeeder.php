<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entity;
use App\Models\AssessmentTarget;

class AssessmentTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entities = Entity::all();
        $year = now()->year;

        // 1. For each Entity, create 12 targets (grouped by entity_id)
        foreach ($entities as $entity) {
            foreach (range(1, 12) as $month) {
                AssessmentTarget::updateOrCreate(
                    [
                        'entity_id' => $entity->id,
                        'location' => null,
                        'year'      => $year,
                        'month'     => $month,
                    ],
                    [
                        'target_count' => rand(0, 18)
                    ]
                );
            }
        }

        // 2. For each location, create 12 targets with entity_id null
        foreach (['Bandung', 'Jakarta'] as $location) {
            foreach (range(1, 12) as $month) {
                AssessmentTarget::updateOrCreate(
                    [
                        'entity_id' => null,
                        'location' => $location,
                        'year'      => $year,
                        'month'     => $month,
                    ],
                    [
                        'target_count' => rand(0, 7)
                    ]
                );
            }
        }
    }
}