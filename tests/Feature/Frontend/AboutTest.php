<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Facility;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AboutTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->adminUser = User::factory()->create([
            'role' => 'user',
        ]);

        $this->actingAs($this->adminUser);
    }

    public function test_about_us_page_returns_successful_response()
    {
        $response = $this->get(route('about.us'));

        $response->assertStatus(200);
        $response->assertViewIs('frontend.about.about');
    }

    public function test_services_page_returns_facilities()
    {
        Facility::factory()->create(['facility_name' => 'Gym']);
        Facility::factory()->create(['facility_name' => 'Pool']);

        $response = $this->get(route('services.us'));

        $response->assertStatus(200);
        $response->assertViewIs('frontend.service.service');
        $response->assertViewHas('facilities', function ($facilities) {
            return $facilities->pluck('facility_name')->contains('Gym');
        });
    }

    public function test_terms_us_page_returns_successful_response()
    {
        $response = $this->get(route('terms.us'));

        $response->assertStatus(200);
        $response->assertViewIs('frontend.term.term');
    }

    public function test_privacy_us_page_returns_successful_response()
    {
        $response = $this->get(route('privacy.us'));

        $response->assertStatus(200);
        $response->assertViewIs('frontend.privacy.privacy');
    }

    public function test_testimonials_list_page_returns_testimonials()
    {
        $testimonial = Testimonial::factory()->create([
            'name' => 'John Doe',
            'message' => 'Great service!',
        ]);

        $response = $this->get(route('testimonials.list'));

        $response->assertStatus(200);
        $response->assertViewIs('frontend.testimonial.testimonial');
        $response->assertViewHas('testimonials', function ($testimonials) use ($testimonial) {
            return $testimonials->contains($testimonial);
        });
    }
}
