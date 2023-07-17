<?php

namespace Database\Factories;

use App\Models\Certificates;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certificates>
 */
class CertificatesFactory extends Factory
{
    protected $model = Certificates::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $certificates = ['MS', 'BS', 'PHD'];
        return [
            'title' => $certificates[array_rand($certificates)],
        ];
    }
}
