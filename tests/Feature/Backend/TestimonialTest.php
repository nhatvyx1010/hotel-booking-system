<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Testimonial;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestimonialTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    public function setUp(): void
    {
        parent::setUp();

        // Tạo user admin
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
        ]);

        // Disable CSRF Middleware
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        // Acting as admin
        $this->actingAs($this->adminUser);
    }

    /** @test */
    public function admin_can_view_all_testimonials()
    {
        Testimonial::factory()->count(3)->create();

        $response = $this->get(route('all.testimonial'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.testimonial.all_testimonial');
        $response->assertViewHas('testimonial');
    }

    /** @test */
    public function admin_can_access_add_testimonial_page()
    {
        $response = $this->get(route('add.testimonial'));
        $response->assertStatus(200);
        $response->assertViewIs('backend.testimonial.add_testimonial');
    }

    /** @test */
    public function admin_can_store_testimonial_with_image()
    {
        $response = $this->post(route('testimonial.store'), [
            'name' => 'John Doe',
            'city' => 'New York',
            'message' => 'Great service!',
        ]);

        $response->assertRedirect(route('all.testimonial'));
        $response->assertSessionHas('message', 'Thêm dữ liệu đánh giá thành công');
        $response->assertSessionHas('alert-type', 'success');

        $this->assertDatabaseHas('testimonials', [
            'name' => 'John Doe',
            'city' => 'New York',
            'message' => 'Great service!',
        ]);
    }

    /** @test */
    public function admin_can_access_edit_testimonial_page()
    {
        $testimonial = Testimonial::factory()->create();

        $response = $this->get(route('edit.testimonial', $testimonial->id));
        $response->assertStatus(200);
        $response->assertViewIs('backend.testimonial.edit_testimonial');
        $response->assertViewHas('testimonial', $testimonial);
    }

    /** @test */
    public function admin_can_update_testimonial_without_image()
    {
        $testimonial = Testimonial::factory()->create([
            'name' => 'Old Name',
            'city' => 'Old City',
            'message' => 'Old message',
        ]);

        $response = $this->post(route('testimonial.update'), [
            'id' => $testimonial->id,
            'name' => 'Updated Name',
            'city' => 'Updated City',
            'message' => 'Updated message',
        ]);

        $response->assertRedirect(route('all.testimonial'));
        $response->assertSessionHas('message', 'Cập nhật đánh giá thành công không có hình ảnh');
        $response->assertSessionHas('alert-type', 'success');

        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'name' => 'Updated Name',
            'city' => 'Updated City',
            'message' => 'Updated message',
        ]);
    }
}
