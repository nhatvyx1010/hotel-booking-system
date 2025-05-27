<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_booking_report_by_date_for_admin()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $booking = Booking::factory()->create([
            'check_in' => '2024-07-01',
            'check_out' => '2024-07-03',
        ]);

        $response = $this
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->actingAs($admin)
            ->post(route('search-by-date'), [
                'report_type' => 'date',
                'start_date' => '2024-07-01',
                'end_date' => '2024-07-31',
            ]);

        $response->assertStatus(200);
        $response->assertViewHas('bookings', function ($bookings) use ($booking) {
            return $bookings->contains($booking);
        });
    }

    /** @test */
    public function it_returns_booking_report_by_week_for_hotel_user()
    {
        $hotelUser = User::factory()->create([
            'role' => 'hotel',
        ]);

        $room = Room::factory()->create([
            'hotel_id' => $hotelUser->id,
        ]);

        $booking = Booking::factory()->create([
            'rooms_id' => $room->id,
            'check_in' => '2024-07-08',
            'check_out' => '2024-07-10',
        ]);

        $week = Carbon::parse('2024-07-08')->format('o-\WW'); 

        $response = $this
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->actingAs($hotelUser)
            ->post(route('hotel.search-by-date'), [
                'report_type' => 'week',
                'week' => $week,
            ]);

        $response->assertStatus(200);
        $response->assertViewHas('bookings', function ($bookings) use ($booking) {
            return $bookings->contains($booking);
        });
    }

    /** @test */
    public function it_returns_booking_report_by_month_for_admin()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $booking = Booking::factory()->create([
            'check_in' => '2024-07-15',
            'check_out' => '2024-07-17',
        ]);

        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->actingAs($admin)
            ->post(route('search-by-date'), [
                'report_type' => 'month',
                'month' => '2024-07',
            ]);

        $response->assertStatus(200);
        $response->assertViewHas('bookings', function ($bookings) use ($booking) {
            return $bookings->contains($booking);
        });
    }

    /** @test */
    public function it_returns_booking_report_by_year_for_hotel_user()
    {
        $hotelUser = User::factory()->create([
            'role' => 'hotel',
        ]);

        $room = Room::factory()->create([
            'hotel_id' => $hotelUser->id,
        ]);

        $booking = Booking::factory()->create([
            'rooms_id' => $room->id,
            'check_in' => '2024-01-05',
            'check_out' => '2024-01-07',
        ]);

        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
                    ->actingAs($hotelUser)
                    ->post(route('hotel.search-by-date'), [
            'report_type' => 'year',
            'year' => '2024',
        ]);

        $response->assertStatus(200);
        $response->assertViewHas('bookings', function ($bookings) use ($booking) {
            return $bookings->contains($booking);
        });
    }
}
