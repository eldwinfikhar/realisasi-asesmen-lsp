<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entity;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entities = [
            ['name' => 'Biofarma'],
            ['name' => 'Indofarma'],
            ['name' => 'KFP Jakarta'],
            ['name' => 'KFP Banjaran Prod.'],
            ['name' => 'KFP Banjaran RnD'],
            ['name' => 'KFA'],
            ['name' => 'KFTD'],
            ['name' => 'Phapros'],
            ['name' => 'Lucas Djaja'],
            ['name' => 'Kimia Farma']
        ];

        foreach ($entities as $entity) {
            Entity::create($entity);
        }
    }
}
