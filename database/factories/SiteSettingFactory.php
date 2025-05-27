<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SiteSettingFactory extends Factory
{
    protected $model = \App\Models\SiteSetting::class;

    public function definition()
    {
        return [
            'logo' => 'logo.png',
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'email' => $this->faker->safeEmail,
            'facebook' => 'https://facebook.com/example',
            'twitter' => 'https://twitter.com/example',
            'copyright' => '© 2025 Hotel',
        ];
    }
}
