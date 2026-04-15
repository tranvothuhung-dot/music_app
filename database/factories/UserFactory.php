<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
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
        $name = fake()->name();
        return [
            'username' => $this->generateUniqueUsername($name),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'birth_day' => fake()->optional()->date('Y-m-d', '2005-01-01'),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'full_name' => $name,
            'avatar_image' => fake()->optional()->imageUrl(200, 200, 'people'),
            'role_id' => 2,
        ];
    }

    /**
     * Generate a unique username.
     */
    private function generateUniqueUsername(string $name): string
    {
        $baseUsername = Str::slug($name, '');
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
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
