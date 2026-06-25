<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;
use App\Models\StaffAvailability;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::firstOrCreate(
            ['email' => 'admin@bookeasy.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 20 Customers
        $customers = User::factory(20)->create(['role' => 'customer']);

        // 4 Specific Services
        $serviceNames = [
            'Haircut',
            'Consultation',
            'Training Session',
            'Medical Appointment',
        ];

        $services = collect();

        foreach ($serviceNames as $name) {
            $services->push(Service::factory()->create([
                'name' => $name,
            ]));
        }

        // 5 Staff Members and Availability
        $staffMembers = Staff::factory(5)->create();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        
        foreach ($staffMembers as $staff) {
            foreach ($days as $day) {
                StaffAvailability::factory()->create([
                    'staff_id' => $staff->id,
                    'day_of_week' => $day,
                ]);
            }
        }

        // 50 Appointments
        for ($i = 0; $i < 50; $i++) {
            Appointment::factory()->create([
                'user_id' => $customers->random()->id,
                'service_id' => $services->random()->id,
            ]);
        }
    }
}
