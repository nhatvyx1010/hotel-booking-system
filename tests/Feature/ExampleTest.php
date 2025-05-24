<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\BookArea;
use App\Models\SiteSetting;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        BookArea::factory()->create();
        SiteSetting::factory()->create();

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
