<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'service_id' => Service::factory(),
            'appointment_date' => fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
            'appointment_time' => fake()->time('H:i:00'),
            'status' => fake()->randomElement(['Pending', 'Confirmed', 'Completed', 'Cancelled']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
