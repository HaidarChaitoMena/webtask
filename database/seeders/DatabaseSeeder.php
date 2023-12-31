<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Certificates;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // generate the admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'sex' => 'M',
            'blood_type' => 'O+',
            'approved' => 1,
            'is_admin' => 1,
        ]);
        User::factory(10)->create();

        $certificates = ['MS', 'BS', 'PHD'];
        foreach ($certificates as $certificate) {
            Certificates::factory(1)->create([
                'title' => $certificate
            ]);
        }


        $faker = Factory::create();

        // Get all users and certificates
        $users = User::all();
        $certificates = Certificates::all();

        // Loop through each user and assign random certificates
        foreach ($users as $user) {
            $randomCertificates = $faker->randomElements(
                $certificates,
                3
            );
            $randomCertificate = array_pop($randomCertificates);
            $user->certificates()->attach($randomCertificate->id);
        }
    }
}
