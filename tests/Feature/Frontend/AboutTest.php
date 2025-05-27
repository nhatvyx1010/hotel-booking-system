<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Facility;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\SiteSetting;

class AboutTest extends TestCase
{
    use RefreshDatabase;

    // Biến static để đánh dấu siteSetting đã được tạo
    protected static $siteSettingCreated = false;

protected function setUp(): void
{
    parent::setUp();

    $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

    if (!self::$siteSettingCreated) {
        SiteSetting::factory()->create();
        self::$siteSettingCreated = true;
    }

    // Lấy SiteSetting đầu tiên (đã tạo) và share với view để tránh lỗi null
    $siteSetting = SiteSetting::first();
    $this->app['view']->share('sitesetting', $siteSetting);
}


    public function test_about_us_page_loads_successfully()
    {
        $response = $this->get(route('about.us'));

        $response->assertStatus(200);
        $response->assertViewIs('frontend.about.about');
    }
}
