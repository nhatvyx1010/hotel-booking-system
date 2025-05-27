<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\RoomType;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $hotel;

    public function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->hotel = User::factory()->create([
            'role' => 'hotel',
        ]);
    }

    // ----- ADMIN ROUTES -----

    public function test_admin_can_access_edit_room()
    {
        $this->actingAs($this->hotel);
        $roomtype = RoomType::factory()->create([
            'hotel_id' => $this->hotel->id,
        ]);

        $room = Room::factory()->create([
            'roomtype_id' => $roomtype->id, // gán roomtype_id
        ]);
        
        Facility::factory()->create([
            'hotel_id' => $this->hotel->id,
            'rooms_id' => $room->id,
            'facility_name' => 'Wifi',
        ]);

        $multiImage = MultiImage::factory()->count(2)->create([
            'rooms_id' => $room->id,
            'hotel_id' => $this->hotel->id,
        ]);

        $roomNumber = RoomNumber::factory()->create([
            'rooms_id' => $room->id,
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('edit.room', $room->id));

        $response->assertStatus(200);
        $response->assertViewIs('backend.allroom.rooms.edit_rooms');
        $response->assertViewHasAll(['editData', 'basic_facility', 'multiimgs', 'allroomNo']);
    }

    public function test_admin_update_room_fails_without_facilities()
    {
        $room = Room::factory()->create();
        $data = [
            'total_adult' => 2,
            'total_child' => 1,
            'room_capacity' => 3,
            'price' => 100,
            'size' => '20 sqm',
            'view' => 'sea',
            'bed_style' => 'king',
            'discount' => 10,
            'short_desc' => 'Nice room',
            'description' => 'Full description',
            'facility_name' => null,
        ];

        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('update.room', $room->id), $data);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Xin lỗi! Bạn chưa chọn tiện ích cơ bản nào');
    }

    public function test_admin_can_store_room_number()
    {
        $room = Room::factory()->create();

        $data = [
            'room_type_id' => 1,
            'room_no' => '101',
            'status' => 1,
        ];

        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('store.room.number', $room->id), $data);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Thêm số phòng thành công');

        $this->assertDatabaseHas('room_numbers', [
            'rooms_id' => $room->id,
            'room_no' => '101',
        ]);
    }

    // ----- HOTEL ROUTES -----

    public function test_hotel_cannot_access_edit_room_of_other_hotel()
    {
        $otherRoom = Room::factory()->create(); // hotel_id khác

        $response = $this->actingAs($this->hotel)
            ->get(route('hotel.edit.room', $otherRoom->id));

        $response->assertRedirect(route('hotel.dashboard'));
        $response->assertSessionHas('error', 'Không tìm thấy phòng thuộc khách sạn này');
    }

    public function test_hotel_can_update_room()
    {
        $room = Room::factory()->create(['hotel_id' => $this->hotel->id]);

        $data = [
            'roomtype_name' => 'Deluxe',
            'total_adult' => 2,
            'total_child' => 1,
            'room_capacity' => 3,
            'price' => 120,
            'size' => '25 sqm',
            'view' => 'garden',
            'bed_style' => 'queen',
            'discount' => 5,
            'short_desc' => 'Updated desc',
            'description' => 'Updated full desc',
            'facility_name' => ['Pool', 'Gym'],
        ];

        $response = $this->actingAs($this->hotel)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('hotel.update.room', $room->id), $data);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Cập nhật phòng thành công');

        $this->assertDatabaseHas('facilities', [
            'rooms_id' => $room->id,
            'facility_name' => 'Pool',
            'hotel_id' => $this->hotel->id,
        ]);
    }

    public function test_hotel_update_room_fails_without_facilities()
    {
        $room = Room::factory()->create(['hotel_id' => $this->hotel->id]);

        $data = [
            'roomtype_name' => 'Standard',
            'total_adult' => 1,
            'total_child' => 0,
            'room_capacity' => 1,
            'price' => 80,
            'size' => '15 sqm',
            'view' => 'city',
            'bed_style' => 'single',
            'discount' => 0,
            'short_desc' => 'No facilities',
            'description' => 'No facilities',
            'facility_name' => null,
        ];

        $response = $this->actingAs($this->hotel)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('hotel.update.room', $room->id), $data);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Xin lỗi! Bạn chưa chọn tiện ích cơ bản nào');
    }

    public function test_hotel_can_delete_multi_image()
    {
        $room = Room::factory()->create(['hotel_id' => $this->hotel->id]);
        $multiImage = \App\Models\MultiImage::factory()->create(['rooms_id' => $room->id, 'hotel_id' => $this->hotel->id]);

        $response = $this->actingAs($this->hotel)
            ->get(route('hotel.multi.image.delete', $multiImage->id));

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Xóa đa ảnh hình thành công');
        $this->assertDatabaseMissing('multi_images', ['id' => $multiImage->id]);
    }

    public function test_hotel_multi_image_delete_fails_if_not_exists()
    {
        $response = $this->actingAs($this->hotel)
            ->get(route('hotel.multi.image.delete', 9999)); // id không tồn tại

        $response->assertRedirect();
    }

    public function test_hotel_can_store_room_number()
    {
        $room = Room::factory()->create(['hotel_id' => $this->hotel->id]);

        $data = [
            'room_type_id' => 1,
            'room_no' => '202',
            'status' => 1,
        ];

        $response = $this->actingAs($this->hotel)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('hotel.store.room.number', $room->id), $data);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Thêm số phòng thành công');

        $this->assertDatabaseHas('room_numbers', [
            'rooms_id' => $room->id,
            'room_no' => '202',
        ]);
    }
}
