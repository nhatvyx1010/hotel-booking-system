<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class RoomListTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $hotelUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Tạo user admin
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
        ]);

        // Tạo user hotel (giả sử role 'hotel')
        $this->hotelUser = User::factory()->create([
            'role' => 'hotel',
        ]);
    }

    /*** Tests for Admin role ***/

    public function test_admin_can_view_room_list()
    {
        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->get(route('view.room.list'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.allroom.roomlist.view_roomlist');
        $response->assertViewHas('room_number_list');
    }

    public function test_admin_can_view_add_room_list_page()
    {
        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->get(route('add.room.list'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.allroom.roomlist.add_roomlist');
        $response->assertViewHas('roomtype');
    }

    public function test_admin_store_roomlist_fails_when_checkin_equals_checkout()
    {
        $room = Room::factory()->create(['room_capacity' => 5, 'price' => 100, 'discount' => 0]);

        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('store.roomlist'), [
                'check_in' => '2025-01-01',
                'check_out' => '2025-01-01',
                'available_room' => 5,
                'number_of_rooms' => 1,
                'room_id' => $room->id,
                'number_of_person' => 3,
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '1234567890',
                'country' => 'VN',
                'state' => 'HN',
                'zip_code' => '100000',
                'address' => 'Address 1',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Bạn đã nhập ngày giống nhau');
        $response->assertSessionHas('alert-type', 'error');
    }

    public function test_admin_store_roomlist_fails_when_number_of_rooms_exceed_available()
    {
        $room = Room::factory()->create(['room_capacity' => 5, 'price' => 100, 'discount' => 0]);

        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('store.roomlist'), [
                'check_in' => '2025-01-01',
                'check_out' => '2025-01-02',
                'available_room' => 1,
                'number_of_rooms' => 2, // vượt quá available_room
                'room_id' => $room->id,
                'number_of_person' => 3,
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '1234567890',
                'country' => 'VN',
                'state' => 'HN',
                'zip_code' => '100000',
                'address' => 'Address 1',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Số phòng đặt vượt quá số phòng hiện có!');
        $response->assertSessionHas('alert-type', 'error');
    }

    public function test_admin_store_roomlist_fails_when_number_of_person_exceed_capacity()
    {
        $room = Room::factory()->create(['room_capacity' => 2, 'price' => 100, 'discount' => 0]);

        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('store.roomlist'), [
                'check_in' => '2025-01-01',
                'check_out' => '2025-01-02',
                'available_room' => 5,
                'number_of_rooms' => 1,
                'room_id' => $room->id,
                'number_of_person' => 5, // vượt quá sức chứa
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '1234567890',
                'country' => 'VN',
                'state' => 'HN',
                'zip_code' => '100000',
                'address' => 'Address 1',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Số lượng khách vượt quá sức chứa của phòng!');
        $response->assertSessionHas('alert-type', 'error');
    }

    public function test_admin_store_roomlist_success()
    {
        $room = Room::factory()->create(['room_capacity' => 5, 'price' => 100, 'discount' => 10]);

        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('store.roomlist'), [
                'check_in' => '2025-01-01',
                'check_out' => '2025-01-03',
                'available_room' => 5,
                'number_of_rooms' => 2,
                'room_id' => $room->id,
                'number_of_person' => 3,
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '1234567890',
                'country' => 'VN',
                'state' => 'HN',
                'zip_code' => '100000',
                'address' => 'Address 1',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Đặt phòng thành công');
        $response->assertSessionHas('alert-type', 'success');

        $this->assertDatabaseHas('bookings', [
            'rooms_id' => $room->id,
            'name' => 'Test User',
            'number_of_rooms' => 2,
        ]);
    }

    /*** Tests for Hotel role ***/

    public function test_hotel_can_view_room_list()
    {
        $response = $this->actingAs($this->hotelUser)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->get(route('hotel.view.room.list'));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.backend.allroom.roomlist.view_roomlist');
        $response->assertViewHas('room_number_list');
    }

    public function test_hotel_store_roomlist_fails_when_checkin_equals_checkout()
    {
        $room = Room::factory()->create(['hotel_id' => $this->hotelUser->id, 'room_capacity' => 5, 'price' => 100, 'discount' => 0]);

        $response = $this->actingAs($this->hotelUser)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('hotel.store.roomlist'), [
                'check_in' => '2025-01-01',
                'check_out' => '2025-01-01',
                'available_room' => 5,
                'number_of_rooms' => 1,
                'room_id' => $room->id,
                'number_of_person' => 3,
                'name' => 'Hotel User',
                'email' => 'hotel@example.com',
                'phone' => '1234567890',
                'country' => 'VN',
                'state' => 'HN',
                'zip_code' => '100000',
                'address' => 'Address Hotel',
                'prepaid_amount' => 100,
                'total_amount' => 300,
                'remaining_amount' => 200,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Bạn đã nhập ngày giống nhau');
        $response->assertSessionHas('alert-type', 'error');
    }

    public function test_hotel_store_roomlist_fails_when_number_of_rooms_exceed_available()
    {
        $room = Room::factory()->create(['hotel_id' => $this->hotelUser->id, 'room_capacity' => 5, 'price' => 100, 'discount' => 0]);

        $response = $this->actingAs($this->hotelUser)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('hotel.store.roomlist'), [
                'check_in' => '2025-01-01',
                'check_out' => '2025-01-02',
                'available_room' => 1,
                'number_of_rooms' => 3,
                'room_id' => $room->id,
                'number_of_person' => 3,
                'name' => 'Hotel User',
                'email' => 'hotel@example.com',
                'phone' => '1234567890',
                'country' => 'VN',
                'state' => 'HN',
                'zip_code' => '100000',
                'address' => 'Address Hotel',
                'prepaid_amount' => 100,
                'total_amount' => 300,
                'remaining_amount' => 200,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Số phòng đặt vượt quá số phòng hiện có!');
        $response->assertSessionHas('alert-type', 'error');
    }

    public function test_hotel_store_roomlist_fails_when_number_of_person_exceed_capacity()
    {
        $room = Room::factory()->create(['hotel_id' => $this->hotelUser->id, 'room_capacity' => 2, 'price' => 100, 'discount' => 0]);

        $response = $this->actingAs($this->hotelUser)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('hotel.store.roomlist'), [
                'check_in' => '2025-01-01',
                'check_out' => '2025-01-02',
                'available_room' => 5,
                'number_of_rooms' => 1,
                'room_id' => $room->id,
                'number_of_person' => 5,
                'name' => 'Hotel User',
                'email' => 'hotel@example.com',
                'phone' => '1234567890',
                'country' => 'VN',
                'state' => 'HN',
                'zip_code' => '100000',
                'address' => 'Address Hotel',
                'prepaid_amount' => 100,
                'total_amount' => 300,
                'remaining_amount' => 200,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Số lượng khách vượt quá sức chứa của phòng!');
        $response->assertSessionHas('alert-type', 'error');
    }
}
