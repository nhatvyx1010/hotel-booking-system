<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\SmtpSetting;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $hotelUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->adminUser = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->hotelUser = User::factory()->create([
            'role' => 'hotel',
        ]);
    }

    /** @test */
    public function admin_can_access_smtp_setting_page()
    {
        $smtp = SmtpSetting::factory()->create(['id' => 1]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('smtp.setting'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.setting.smtp_update');
        $response->assertViewHas('smtp');
    }

    /** @test */
    public function admin_can_update_smtp_setting()
    {
        $smtp = SmtpSetting::factory()->create(['id' => 1]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('smtp.update'), [
                'id' => $smtp->id,
                'mailer' => 'smtp',
                'host' => 'smtp.mailtrap.io',
                'port' => 2525,
                'username' => 'user',
                'password' => 'secret',
                'encryption' => 'tls',
                'from_address' => 'admin@example.com',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('smtp_settings', [
            'id' => 1,
            'host' => 'smtp.mailtrap.io',
            'username' => 'user',
        ]);
    }
}
