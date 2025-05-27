<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\RoomType;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomTypeTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->hotelUser = User::factory()->create([
            'role' => 'hotel',
        ]);

        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    public function test_admin_can_access_room_type_list()
    {
        $response = $this->actingAs($this->adminUser)
                         ->get(route('room.type.list'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.allroom.roomtype.view_roomtype');
    }

    public function test_admin_can_access_add_room_type_form()
    {
        $response = $this->actingAs($this->adminUser)
                         ->get(route('add.room.type'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.allroom.roomtype.add_roomtype');
    }

    public function test_hotel_user_can_access_hotel_room_type_list()
    {
        $response = $this->actingAs($this->hotelUser)
                         ->get(route('hotel.room.type.list'));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.backend.allroom.roomtype.view_roomtype');
    }

    public function test_hotel_user_can_access_hotel_add_room_type_form()
    {
        $response = $this->actingAs($this->hotelUser)
                         ->get(route('hotel.add.room.type'));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.backend.allroom.roomtype.add_roomtype');
    }

    public function test_hotel_user_can_store_new_room_type()
    {
        $postData = [
            'name' => 'Suite Room',
        ];

        $response = $this->actingAs($this->hotelUser)
                         ->post(route('hotel.room.type.store'), $postData);

        $response->assertRedirect(route('hotel.room.type.list'));
        $response->assertSessionHas('message', 'Loại phòng đã được thêm thành công');
        $response->assertSessionHas('alert-type', 'success');

        // Kiểm tra dữ liệu room type lưu với hotel_id = user id
        $this->assertDatabaseHas('room_types', [
            'name' => 'Suite Room',
            'hotel_id' => $this->hotelUser->id,
        ]);

        $roomtype = RoomType::where('name', 'Suite Room')
                            ->where('hotel_id', $this->hotelUser->id)
                            ->first();

        $this->assertNotNull($roomtype);

        // Kiểm tra phòng cũng được thêm với hotel_id và roomtype_id
        $this->assertDatabaseHas('rooms', [
            'roomtype_id' => $roomtype->id,
            'hotel_id' => $this->hotelUser->id,
        ]);
    }
}
