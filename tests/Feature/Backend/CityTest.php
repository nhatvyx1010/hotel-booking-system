<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    /** @test */
    public function it_can_display_all_cities()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->actingAs($this->adminUser);
        City::factory()->count(3)->create();

        $response = $this->get(route('all.city'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.city.all_city');
        $response->assertViewHas('cities');
    }

    /** @test */
    public function it_can_display_add_city_form()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->actingAs($this->adminUser);
        $response = $this->get(route('add.city'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.city.add_city');
    }

    /** @test */
    public function it_can_store_a_new_city_without_image()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->actingAs($this->adminUser);

        $data = [
            'name' => 'City Without Image',
            'description' => 'A city without uploading image',
        ];

        $response = $this->post(route('city.store'), $data);

        $response->assertRedirect(route('all.city'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('cities', [
            'name' => 'City Without Image',
            'description' => 'A city without uploading image',
            'slug' => 'city-without-image',
            'image' => null,
        ]);
    }

    /** @test */
    public function it_validates_required_fields_when_storing_city()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->actingAs($this->adminUser);
        $response = $this->post(route('city.store'), []);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function it_can_display_edit_form()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->actingAs($this->adminUser);
        $city = City::factory()->create();

        $response = $this->get(route('edit.city', $city->id));

        $response->assertStatus(200);
        $response->assertViewIs('backend.city.edit_city');
        $response->assertViewHas('city', $city);
    }

    /** @test */
    public function it_can_update_city_without_changing_image()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $this->actingAs($this->adminUser);
        Storage::fake('public');

        $city = City::factory()->create([
            'image' => 'upload/city/original.jpg',
        ]);

        // Giả lập file ảnh cũ tồn tại
        Storage::disk('public')->put('city/original.jpg', 'dummy content');

        $data = [
            'id' => $city->id,
            'name' => 'City Name Unchanged Image',
            'description' => 'Updated description without new image',
        ];

        $response = $this->post(route('city.update'), $data);

        $response->assertRedirect(route('all.city'));
        $response->assertSessionHas('success');

        // Kiểm tra database
        $this->assertDatabaseHas('cities', [
            'id' => $city->id,
            'name' => 'City Name Unchanged Image',
            'slug' => 'city-name-unchanged-image',
            'description' => 'Updated description without new image',
            'image' => 'upload/city/original.jpg',
        ]);

        // Ảnh cũ vẫn tồn tại
        Storage::disk('public')->assertExists('city/original.jpg');
    }

    /** @test */
    public function it_can_delete_city_without_image()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $this->actingAs($this->adminUser);

        // Tạo city không có ảnh
        $city = City::factory()->create([
            'image' => null,
        ]);

        $response = $this->get(route('delete.city', $city->id));

        $response->assertRedirect(route('all.city'));
        $response->assertSessionHas('success');

        // Kiểm tra bản ghi đã bị xoá
        $this->assertDatabaseMissing('cities', ['id' => $city->id]);
    }
}
