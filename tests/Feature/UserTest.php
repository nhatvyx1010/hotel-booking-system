<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\City;
use App\Models\Room;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserTest extends TestCase
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

        $this->actingAs($this->adminUser);
    }

    /** @test */
    public function test_index_page_loads_with_cities()
    {
        $city = City::factory()->create();
        $hotel = User::factory()->create([
            'city_id' => $city->id,
            'status' => 'active',
        ]);
        $room = Room::factory()->create([
            'hotel_id' => $hotel->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.index');
        $response->assertViewHas('cities');
    }

    /** @test */
    public function profile_page_loads_with_user_data()
    {
        $response = $this->get(route('user.profile'));

        $response->assertStatus(200);
        $response->assertViewIs('frontend.dashboard.edit_profile');
        $response->assertViewHas('profileData', $this->adminUser);
    }

    /** @test */
    public function user_can_update_profile_without_photo()
    {
        $response = $this->post(route('profile.store'), [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'phone' => '0123456789',
            'address' => '123 New Address',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $this->adminUser->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);
    }

    /** @test */
    public function user_can_update_profile_with_photo()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->post(route('profile.store'), [
            'name' => 'Photo User',
            'email' => 'photo@example.com',
            'phone' => '0987654321',
            'address' => '456 Image Address',
            'photo' => $file,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => 'photo@example.com',
        ]);
    }

    /** @test */
    public function user_can_logout()
    {
        $response = $this->get(route('user.logout'));

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /** @test */
    public function change_password_page_loads()
    {
        $response = $this->get(route('user.change.password'));

        $response->assertStatus(200);
        $response->assertViewIs('frontend.dashboard.user_change_password');
    }

    /** @test */
    public function user_can_change_password_with_correct_old_password()
    {
        $this->adminUser->update([
            'password' => bcrypt('oldpass'),
        ]);

        $response = $this->post(route('password.change.store'), [
            'old_password' => 'oldpass',
            'new_password' => 'newpass123',
            'new_password_confirmation' => 'newpass123',
        ]);

        $response->assertRedirect();
        $this->assertTrue(\Hash::check('newpass123', $this->adminUser->fresh()->password));
    }

    /** @test */
    public function user_cannot_change_password_with_wrong_old_password()
    {
        $this->adminUser->update([
            'password' => bcrypt('correctpass'),
        ]);

        $response = $this->post(route('password.change.store'), [
            'old_password' => 'wrongpass',
            'new_password' => 'newpass123',
            'new_password_confirmation' => 'newpass123',
        ]);

        $response->assertRedirect();
        $this->assertTrue(\Hash::check('correctpass', $this->adminUser->fresh()->password));
    }

    /** @test */
    public function user_can_send_message_to_chat_api()
    {
        \Illuminate\Support\Facades\Http::fake([
            'http://192.168.254.1:8001/chat' => \Illuminate\Support\Facades\Http::response([
                'message' => 'Hello back!',
                'history' => [['message' => 'Hello', 'response' => 'Hi']],
            ], 200),
        ]);

        $response = $this->post(route('send.message'), [
            'message' => 'Hello',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'history']);
    }

    /** @test */
    public function user_send_message_api_fails_with_error()
    {
        \Illuminate\Support\Facades\Http::fake([
            'http://192.168.254.1:8001/chat' => \Illuminate\Support\Facades\Http::response([], 500),
        ]);

        $response = $this->post(route('send.message'), [
            'message' => 'Test',
        ]);

        $response->assertStatus(500);
        $response->assertJson(['error' => 'Không thể gửi tin nhắn']);
    }
}
