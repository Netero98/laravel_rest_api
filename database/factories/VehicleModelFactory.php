<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VehicleModel>
 */
class VehicleModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $allBrandsId = Brand::all('id')->toArray();

        $randKey = array_rand($allBrandsId);

        return [
            'brand_id' => $allBrandsId[$randKey]['id'],
            'name' => $this->faker->city,
        ];
    }
}
