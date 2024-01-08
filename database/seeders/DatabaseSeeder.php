<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\User;
use App\Models\VehicleModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Brand::factory(2)->create();

        VehicleModel::factory(1)->create([
            'id' => '9ac6f94b-fe4e-4bcb-a4fd-e9951a3ca552',
        ]);

        VehicleModel::factory(5)->create();
    }
}
