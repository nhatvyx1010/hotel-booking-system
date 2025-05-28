<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\BookingRoomList;
use App\Models\RoomBookedDate;
use App\Models\RoomNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookCancelConfirm;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

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
        $this->actingAs($this->adminUser);
    }

    /** @test */
    public function it_can_show_checkout_page_if_session_has_book_date()
    {
        $user = User::factory()->create(); // tạo user mới
        $this->actingAs($user); // đăng nhập user này

        $room = Room::factory()->create();

        Session::put('book_date', [
            'room_id' => $room->id,
            'check_in' => now()->format('Y-m-d'),
            'check_out' => now()->addDays(2)->format('Y-m-d'),
            'number_of_rooms' => 1,
            'persion' => 2
        ]);

        $response = $this->get(route('checkout'));
        $response->assertStatus(200);
        $response->assertViewIs('frontend.checkout.checkout');
    }

    /** @test */
    public function it_redirects_from_checkout_if_session_missing()
    {
        Session::forget('book_date');
        $response = $this->get(route('checkout'));

        $response->assertRedirect('/');
        $response->assertSessionHas('message', 'Đã xảy ra lỗi!');
    }

    /** @test */
    public function it_redirects_back_if_number_of_rooms_exceeds_available()
    {
        $room = Room::factory()->create();

        $response = $this->post(route('user_booking_store'), [
            'room_id' => $room->id,
            'number_of_rooms' => 3,
            'available_room' => 2,
            'check_in' => now()->format('Y-m-d'),
            'check_out' => now()->addDay()->format('Y-m-d'),
            'persion' => 2,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Đã xảy ra lỗi!');
    }

    /** @test */
    public function it_stores_booking_and_redirects_to_checkout()
    {
        $room = Room::factory()->create();

        $response = $this->post(route('user_booking_store'), [
            'room_id' => $room->id,
            'number_of_rooms' => 1,
            'available_room' => 2,
            'check_in' => now()->format('Y-m-d'),
            'check_out' => now()->addDay()->format('Y-m-d'),
            'persion' => 2,
        ]);

        $response->assertRedirect(route('checkout'));
        $this->assertTrue(Session::has('book_date'));
    }

    /** @test */
    public function it_requires_checkout_fields()
    {
        $response = $this->post(route('checkout.store'), []);
        $response->assertSessionHasErrors([
            'name', 'email', 'country', 'phone', 'address', 'state', 'payment_method'
        ]);
    }

    /** @test */
    public function it_can_store_booking_with_cod_payment()
    {
        $room = Room::factory()->create(['price' => 100, 'discount' => 10]);

        Session::put('book_date', [
            'room_id' => $room->id,
            'check_in' => now()->format('Y-m-d'),
            'check_out' => now()->addDay()->format('Y-m-d'),
            'number_of_rooms' => 1,
            'persion' => 2,
        ]);

        $response = $this->post(route('checkout.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'country' => 'Vietnam',
            'phone' => '0123456789',
            'address' => '123 Street',
            'state' => 'HCM',
            'payment_method' => 'COD',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('bookings', ['name' => 'Test User']);
    }

    /** @test */
    public function it_shows_booking_list_for_admin()
    {
        Booking::factory()->count(3)->create();

        $response = $this->get(route('booking.list'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.booking.booking_list');
    }

    /** @test */
    public function it_shows_cancel_pending_booking_list_for_hotel()
    {
        $hotelUser = User::factory()->create(['role' => 'hotel']);
        $this->actingAs($hotelUser);

        $response = $this->get(route('hotel.booking.cancel_pending.list'));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.backend.booking.booking_cancel_pending_list');
    }

    /** @test */
    public function it_shows_cancel_complete_booking_list_for_hotel()
    {
        $hotelUser = User::factory()->create(['role' => 'hotel']);
        $this->actingAs($hotelUser);

        $response = $this->get(route('hotel.booking.cancel_complete.list'));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.backend.booking.booking_cancel_complete_list');
    }

    /** @test */
    public function update_booking_fails_when_available_room_less_than_requested()
    {
        $booking = Booking::factory()->create();

        $response = $this->post(route('update.booking', $booking->id), [
            'available_room' => 1,
            'number_of_rooms' => 2,
            'check_in' => '2025-06-01',
            'check_out' => '2025-06-03',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Đã xảy ra lỗi!');
        $response->assertSessionHas('alert-type', 'error');
    }

    /** @test */
    public function update_booking_successfully_updates_and_creates_room_booked_dates()
    {
        $booking = Booking::factory()->create(['rooms_id' => 1, 'number_of_rooms' => 1]);

        $response = $this->post(route('update.booking', $booking->id), [
            'available_room' => 3,
            'number_of_rooms' => 2,
            'check_in' => '2025-06-01',
            'check_out' => '2025-06-05',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Cập nhật đặt phòng thành công');
        $response->assertSessionHas('alert-type', 'success');

        $booking->refresh();
        $this->assertEquals(2, $booking->number_of_rooms);
        $this->assertEquals('2025-06-01', $booking->check_in);
        $this->assertEquals('2025-06-05', $booking->check_out);

        // Check RoomBookedDate records created for each date except check_out date
        $dates = RoomBookedDate::where('booking_id', $booking->id)->pluck('book_date')->toArray();
        $this->assertContains('2025-06-01', $dates);
        $this->assertContains('2025-06-04', $dates); // last day before check_out
        $this->assertNotContains('2025-06-05', $dates);
    }

    /** @test */
    public function assign_room_returns_view_with_booking_and_room_numbers()
    {
        $booking = Booking::factory()->create(['rooms_id' => 1]);
        $roomNumber = RoomNumber::factory()->create(['rooms_id' => $booking->rooms_id, 'status' => 'Active']);

        $response = $this->get(route('assign_room', $booking->id));

        $response->assertStatus(200);
        $response->assertViewIs('backend.booking.assign_room');
        $response->assertViewHasAll(['booking', 'room_numbers']);
    }

    /** @test */
    public function hotel_assign_room_returns_view_with_booking_and_room_numbers_filtered_by_hotel()
    {
        $hotel = $this->hotelUser;

        $booking = Booking::factory()->create(['rooms_id' => 1]);
        $roomNumber = RoomNumber::factory()->create([
            'rooms_id' => $booking->rooms_id,
            'status' => 'Active',
            'hotel_id' => $hotel->id,
        ]);

        $this->actingAs($hotel);

        $response = $this->get(route('hotel.assign_room', $booking->id));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.backend.booking.assign_room');
        $response->assertViewHasAll(['booking', 'room_numbers']);
    }
    
    /** @test */
    public function assign_room_store_fails_if_already_assigned()
    {
        $booking = Booking::factory()->create(['rooms_id' => 1, 'number_of_rooms' => 1]);
        $roomNumber = RoomNumber::factory()->create(['rooms_id' => $booking->rooms_id, 'status' => 'Active']);

        BookingRoomList::factory()->create([
            'booking_id' => $booking->id,
            'room_number_id' => $roomNumber->id,
            'room_id' => $booking->rooms_id,
        ]);

        $response = $this->get(route('assign_room_store', [$booking->id, $roomNumber->id]));

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Phòng đã được gán trước đó');
        $response->assertSessionHas('alert-type', 'error');
    }

    /** @test */
    public function check_room_availability_returns_correct_data()
    {
        $hotel = $this->hotelUser;

        $room = Room::factory()->create(['hotel_id' => $hotel->id]);

        RoomNumber::factory()->count(5)->create([
            'rooms_id' => $room->id,
            'status' => 'Active'
        ]);

        $booking = Booking::factory()->create(['rooms_id' => $room->id]);

        $roomNumberBooked = RoomNumber::factory()->create([
            'rooms_id' => $room->id,
            'status' => 'Active'
        ]);

        BookingRoomList::factory()->create([
            'booking_id' => $booking->id,
            'room_number_id' => $roomNumberBooked->id,
            'room_id' => $room->id,
        ]);

        RoomBookedDate::factory()->create([
            'booking_id' => $booking->id,
            'room_id' => $room->id,
            'book_date' => '2025-06-01',
        ]);

        $this->actingAs($hotel, 'hotel');

        $response = $this->get(route('hotel.check_room_availability', [
            'hotel_id' => $hotel->id,
            'room_id' => $room->id,
            'check_in' => '2025-06-01',
            'check_out' => '2025-06-02',
        ]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['available_room', 'total_nights']);
        $this->assertIsInt($response->json('available_room'));
    }
}
