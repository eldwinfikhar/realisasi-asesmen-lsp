<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Eldwin Fikhar Ananda',
            'email' => 'eldwinfikhar@student.telkomuniversity.ac.id',
            'password' => bcrypt('123456'),
        ]);
    }
}
