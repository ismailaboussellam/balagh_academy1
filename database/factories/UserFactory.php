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
    protected static ?string $password;

    public function definition(): array
    {
        $birthYear = fake()->numberBetween(1970, 2015);
        $age = now()->year - $birthYear;
        $fi2a = $age < 18 ? 'sighar' : 'kibar';
        $userType = fake()->randomElement(['admin', 'ostad', 'talib', 'ab']);

        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '+212' . fake()->numerify('6########'),
            'gender' => fake()->randomElement(['male', 'female']),
            'birth_day' => fake()->numberBetween(1, 28),
            'birth_month' => fake()->numberBetween(1, 12),
            'birth_year' => $birthYear,
            'nationality' => fake()->country(),
            'residence_country' => fake()->country(),
            'user_type' => $userType,
            'domain' => fake()->randomElement(['ta3lim_quran', 'dorous_diniya', 'ta3lim_lugha']),
            'fi2a' => $fi2a,
            'child_code' => $userType === 'talib' ? strtoupper(Str::random(8)) : null,
            'password' => static::$password ??= Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
