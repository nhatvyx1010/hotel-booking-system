<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\City;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminHotelTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Giả sử có user role admin để test các route này (có thể cần login nếu middleware kiểm tra)
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_all_hotel_page_shows_hotels()
    {
        $hotel = User::factory()->create([
            'role' => 'hotel',
            'city_id' => City::factory()->create()->id,
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('all.hotel'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.hotel.all_hotel');
        $response->assertSee($hotel->name);
    }

    public function test_add_hotel_page_loads()
    {
        City::factory()->count(3)->create();

        $response = $this->actingAs($this->adminUser)->get(route('add.hotel'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.hotel.add_hotel');
        $response->assertViewHas('cities');
    }

    public function test_store_hotel_validates_and_creates()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        Storage::fake('public');

        $city = City::factory()->create();

        $file = UploadedFile::fake()->image('hotel.jpg');

        $postData = [
            'name' => 'Test Hotel',
            'email' => 'testhotel@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '0123456789',
            'address' => '123 Test Address',
            'city_id' => $city->id,
            'photo' => $file,
        ];

        $response = $this->actingAs($this->adminUser)->post(route('store.hotel'), $postData);

        $response->assertRedirect(route('all.hotel'));
        $response->assertSessionHas('message', 'Thêm khách sạn thành công!');

        $this->assertDatabaseHas('users', [
            'email' => 'testhotel@example.com',
            'role' => 'hotel',
            'city_id' => $city->id,
        ]);

        // Kiểm tra ảnh đã upload
        $hotel = User::where('email', 'testhotel@example.com')->first();
        $this->assertFileExists(public_path('upload/admin_images/' . $hotel->photo));
    }

    public function test_edit_hotel_page_loads()
    {
        $hotel = User::factory()->create([
            'role' => 'hotel',
            'city_id' => City::factory()->create()->id,
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('edit.hotel', $hotel->id));

        $response->assertStatus(200);
        $response->assertViewIs('backend.hotel.edit_hotel');
        $response->assertViewHasAll(['hotel', 'cities']);
    }

    public function test_update_hotel_validates_and_updates()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        Storage::fake('public');

        $hotel = User::factory()->create([
            'role' => 'hotel',
            'city_id' => City::factory()->create()->id,
            'photo' => null,
        ]);
        $city = City::factory()->create();

        $file = UploadedFile::fake()->image('newphoto.jpg');

        $postData = [
            'name' => 'Updated Hotel',
            'email' => $hotel->email, // dùng email cũ để không vi phạm unique
            'phone' => '0987654321',
            'address' => 'Updated Address',
            'city_id' => $city->id,
            'status' => 'inactive',
            'image' => $file,
        ];

        $response = $this->actingAs($this->adminUser)->post(route('update.hotel', $hotel->id), $postData);

        $response->assertRedirect(route('all.hotel'));
        $response->assertSessionHas('message', 'Cập nhật khách sạn thành công!');

        $this->assertDatabaseHas('users', [
            'id' => $hotel->id,
            'name' => 'Updated Hotel',
            'phone' => '0987654321',
            'address' => 'Updated Address',
            'city_id' => $city->id,
            'status' => 'inactive',
        ]);

        $hotel->refresh();
    }

    public function test_delete_hotel_deletes_record()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $hotel = User::factory()->create([
            'role' => 'hotel',
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('delete.hotel', $hotel->id));

        $response->assertRedirect(route('all.hotel'));
        $response->assertSessionHas('message', 'Xóa khách sạn thành công!');

        $this->assertDatabaseMissing('users', [
            'id' => $hotel->id,
        ]);
    }

}
