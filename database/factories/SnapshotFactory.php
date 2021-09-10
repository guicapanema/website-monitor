<?php

namespace Database\Factories;

use App\Models\Snapshot;
use App\Models\Website;
use Illuminate\Database\Eloquent\Factories\Factory;

class SnapshotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Snapshot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'website_id' => Website::factory(),
            'content' => $this->faker->randomHtml(),
            'created_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
