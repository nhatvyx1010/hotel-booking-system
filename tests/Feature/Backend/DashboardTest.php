<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_weekly_booking_data()
    {
        $this->withoutExceptionHandling();

        // Arrange
        Booking::factory()->count(3)->create([
            'check_in' => Carbon::now()->startOfWeek()->addDays(1),
        ]);

        // Act
        $response = $this->getJson('/admin/bookings/chart-data?type=week');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            ['label', 'value']
        ]);
    }

    /** @test */
    public function it_returns_monthly_booking_data()
    {
        $this->withoutExceptionHandling();

        // Arrange
        Booking::factory()->create([
            'check_in' => Carbon::now()->startOfMonth()->addDays(2),
        ]);

        // Act
        $response = $this->getJson('/admin/bookings/chart-data?type=month');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            ['label', 'value']
        ]);
    }

    /** @test */
    public function it_returns_yearly_booking_data()
    {
        $this->withoutExceptionHandling();

        // Arrange
        Booking::factory()->create([
            'check_in' => Carbon::now()->startOfYear()->addMonths(1),
        ]);

        // Act
        $response = $this->getJson('/admin/bookings/chart-data?type=year');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            ['label', 'value']
        ]);
    }

    /** @test */
    public function it_returns_booking_data_for_specific_hotel_weekly()
    {
        $this->withoutExceptionHandling();

        // Arrange
        $hotelUser = User::factory()->create();
        $this->actingAs($hotelUser);

        Booking::factory()->create([
            'check_in' => Carbon::now()->startOfWeek()->addDays(1),
        ]);

        // Act
        $response = $this->getJson('/admin/bookings/chart-data-hotel?type=week');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            ['label', 'value']
        ]);
    }
}
