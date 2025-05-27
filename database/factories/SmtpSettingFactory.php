<?php

namespace Database\Factories;

use App\Models\SmtpSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SmtpSettingFactory extends Factory
{
    protected $model = SmtpSetting::class;

    public function definition()
    {
        return [
            'mailer' => 'smtp',
            'host' => 'smtp.example.com',
            'port' => 587,
            'username' => 'user',
            'password' => 'password',
            'encryption' => 'tls',
            'from_address' => 'example@example.com',
        ];
    }
}
