<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake() -> name(),
            'age' => fake() -> randomNumber(2),
            'position' => fake() -> realText(10),
            'playStyle' => fake() -> realText(10),
        ];
    }
}
