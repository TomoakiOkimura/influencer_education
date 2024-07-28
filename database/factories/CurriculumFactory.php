<?php

namespace Database\Factories;

use App\Models\Curriculum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curriculum>
 */
class CurriculumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
      
           'title' => $this->faker->name(),
            'description' => $this->faker->sentence(50),
            'alway_delivery_flg' => $this->faker->boolean(),
            'grade_id' => $this->faker->numberBetween(1, 12),
            'created_at' => now()
           
        ];
    }
}
