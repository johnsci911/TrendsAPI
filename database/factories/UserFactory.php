<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $link = collect(['twitter.com', 'instagram.com', 'facebook.com', 'linkedIn.com', 'gitHub.com'])->random();

        return [
            'name' => fake()->name(),
            'username' => $this->faker->unique()->userName(),
            'avatar' => 'https://i.pravatar.cc/150?img='.$this->faker->numberBetween(1, 70),
            'profile' => fake()->sentence(14),
            'location' => fake()->city() . ', ' . fake()->country(),
            'link' => 'https://' . $link,
            'link_text' => $link,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'created_at' => fake()->dateTimeBetween('-5 years', 'now'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
