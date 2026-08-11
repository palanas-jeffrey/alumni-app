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
    // public function definition(): array
    // {
    //     return [
    //         'name' => fake()->name(),
    //         'email' => fake()->unique()->safeEmail(),
    //         'email_verified_at' => now(),
    //         'password' => static::$password ??= Hash::make('password'),
    //         'remember_token' => Str::random(10),
    //     ];
    // }

    protected static $counter = 2;

    public function definition()
    {
        $batchYear = '2023-2024';
        $year = explode('-', $batchYear)[1];

        $newNumber = str_pad(self::$counter++, 4, '0', STR_PAD_LEFT);

        $newAlumniId = "ALU-$year-$newNumber";

        return [
            'alumni_id' => $newAlumniId,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'middle_name' => '',
            'maiden_name' => '',
            'date_of_birth' => $this->faker->dateTimeBetween('1998-01-01', '2002-12-31')->format('Y-m-d'),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'email' => $this->faker->unique()->userName() . '@gmail.com',
            'current_address' => '',
            'permanent_address' => '',
            'password' => \Illuminate\Support\Facades\Hash::make('1234qwer'),
            'program_id' => $this->faker->numberBetween(1, 3),
            'batch_year' => $batchYear,
            'civil_status' => $this->faker->randomElement(['single', 'married', 'widowed', 'separated']),
            'email_verified_at' => \Carbon\Carbon::now()
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
