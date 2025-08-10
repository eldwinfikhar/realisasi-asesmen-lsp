<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assessee;
use App\Models\Entity;

class AssesseeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $externalEntities = Entity::whereIn('name', ['Biofarma', 'Kimia Farma'])->get();
        $externalLocations = ['Bandung', 'Jakarta'];

        if ($externalEntities->isEmpty()) {
            $this->command->error('External entities (Biofarma, Kimia Farma) not found. Please run EntitySeeder first.');
            return;
        }

        // 1. 250 Internal assessees: random band, random city location, exclude 'Kimia Farma'
        $internalEntities = Entity::where('name', '!=', 'Kimia Farma')->get();
        Assessee::factory()->count(250)->state(function () use ($internalEntities) {
            return [
                'assessee_type' => 'Internal',
                'band'          => fake()->randomElement(['I', 'II', 'III', 'IV', 'V']),
                'location'      => null,
                'entity_id'     => $internalEntities->random()->id,
            ];
        })->create();

        // 2. 50 Eksternal assessees: band and location must be null
        Assessee::factory()->count(50)->state(function () use ($externalEntities, $externalLocations) {
            return [
                'assessee_type' => 'Eksternal',
                'band'          => null,
                'location'      => fake()->randomElement($externalLocations),
                'entity_id'     => $externalEntities->random()->id,
            ];
        })->create();
    }
}
