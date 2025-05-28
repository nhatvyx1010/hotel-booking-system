<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Room;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\RoomBookedDate;
use App\Models\Booking;
use App\Models\City;
use App\Models\BookArea;
use App\Models\Review;
use App\Models\Gallery;
use App\Models\RoomType;
use Carbon\Carbon;

class FrontendRoomControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Tạo admin user
        $this->hotelUser = User::factory()->create([
            'role' => 'hotel',
        ]);

        // Disable middleware VerifyCsrfToken
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    /** @test */
    public function admin_can_access_all_frontend_rooms()
    {
        $this->actingAs($this->hotelUser);

        Room::factory()->count(3)->create();

        $response = $this->get(route('hotel.view.room.list'));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.backend.allroom.roomlist.view_roomlist');
        $response->assertViewHas('room_number_list');
    }

    /** @test */
    public function booking_search_fails_if_check_in_equals_check_out()
    {
        $this->actingAs($this->hotelUser);

        $response = $this->get(route('booking.search', [
            'check_in' => '2025-06-01',
            'check_out' => '2025-06-01',
        ]));

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Đã xảy ra lỗi!');
        $response->assertSessionHas('alert-type', 'error');
    }

    /** @test */
    public function search_room_details_displays_correct_data()
    {
        $this->actingAs($this->hotelUser);

        $hotel = User::factory()->create([
            'role' => 'hotel',
        ]);

        $roomType = RoomType::factory()->create();

        $room = Room::factory()->create([
            'hotel_id' => $hotel->id,
            'roomtype_id' => $roomType->id,
        ]);

        MultiImage::factory()->count(2)->create(['rooms_id' => $room->id]);
        Facility::factory()->count(2)->create(['rooms_id' => $room->id]);

        Review::factory()->count(2)->create([
            'hotel_id' => $hotel->id,
            'status' => 'approved',
            'parent_id' => null,
        ]);

        $response = $this->get(route('search_room_details', ['id' => $room->id]));

        $response->assertStatus(200);
        $response->assertViewIs('frontend.room.search_room_details');
        $response->assertViewHasAll([
            'roomdetails',
            'multiImage',
            'facility',
            'otherRooms',
            'room_id',
            'hotel',
            'reviews',
            'canReview'
        ]);
    }

    /** @test */
    public function check_room_availability_returns_json()
    {
        $this->actingAs($this->hotelUser);

        $room = Room::factory()->create(['hotel_id' => $this->hotelUser->id]);

        $response = $this->getJson(route('check_room_availability', [
            'check_in' => '2025-06-01',
            'check_out' => '2025-06-05',
            'room_id' => $room->id,
        ]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'available_room',
            'total_nights',
            'room_price',
        ]);
    }

    /** @test */
    public function booking_list_room_search_fails_if_dates_equal()
    {
        $this->actingAs($this->hotelUser);

        $response = $this->get(route('booking.list.room.search', [
            'check_in' => '2025-06-01',
            'check_out' => '2025-06-01',
        ]));

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Đã xảy ra lỗi!');
        $response->assertSessionHas('alert-type', 'error');
    }
}
