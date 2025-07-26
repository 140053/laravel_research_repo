<?php

namespace Database\Factories;

use App\Models\Albums;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Albums>
 */
class AlbumsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'description' => fake()->paragraph(),
        ];
    }

    /**
     * Indicate that the album has no description.
     */
    public function withoutDescription(): static
    {
        return $this->state(fn (array $attributes) => [
            'description' => null,
        ]);
    }

    /**
     * Indicate that the album has a short description.
     */
    public function withShortDescription(): static
    {
        return $this->state(fn (array $attributes) => [
            'description' => fake()->sentence(),
        ]);
    }

    /**
     * Indicate that the album has a long description.
     */
    public function withLongDescription(): static
    {
        return $this->state(fn (array $attributes) => [
            'description' => fake()->paragraphs(3, true),
        ]);
    }
} 