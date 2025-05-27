<?php

namespace Tests\Unit\Controllers\Backend;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Gallery;
use App\Models\User;
use App\Models\Contact;
use App\Models\SiteSetting;

class GalleryTest extends TestCase
{
    use RefreshDatabase;

    // Chuẩn bị user admin và hotel trước khi test
    protected $adminUser;
    protected $hotelUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'role' => 'admin',
        ]);
        $this->hotelUser = User::factory()->create([
            'role' => 'hotel',
        ]);

        Storage::fake('public');
    }

    /** @test */
    public function admin_can_view_all_gallery()
    {
        $this->actingAs($this->adminUser);
        Gallery::factory()->count(3)->create();

        $response = $this->get(route('all.gallery'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.gallery.all_gallery');
        $response->assertViewHas('gallery');
    }

    /** @test */
    public function hotel_can_view_only_own_gallery()
    {
        $this->actingAs($this->hotelUser);

        Gallery::factory()->count(2)->create(['hotel_id' => $this->hotelUser->id]);

        $response = $this->get(route('hotel.all.gallery'));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.backend.gallery.all_gallery');

        $galleries = $response->viewData('gallery');
        $this->assertCount(2, $galleries);
        foreach ($galleries as $gallery) {
            $this->assertEquals($this->hotelUser->id, $gallery->hotel_id);
        }
    }
    
    /** @test */
    public function can_store_contact_message()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        SiteSetting::factory()->create();

        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '0123456789',
            'subject' => 'Test Subject',
            'message' => 'Test message body',
        ];

        $response = $this->post(route('store.contact'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('contacts', [
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
        ]);
    }

    /** @test */
    public function admin_can_view_contact_messages()
    {
        $this->actingAs($this->adminUser);

        Contact::factory()->count(5)->create();

        $response = $this->get(route('contact.message'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.contact.contact_message');
        $response->assertViewHas('contact');
    }
}
