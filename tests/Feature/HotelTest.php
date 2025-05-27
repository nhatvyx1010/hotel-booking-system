<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Tests\TestCase;

class HotelTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_register_form()
    {
        $response = $this->get(route('hotel.register'));
        $response->assertStatus(200);
        $response->assertViewIs('hotel.hotel_register');
    }

    public function test_show_login_form()
    {
        $response = $this->get(route('hotel.login'));
        $response->assertStatus(200);
        $response->assertViewIs('hotel.hotel_login');
    }

    public function test_register_hotel_user()
    {
        Event::fake();

        $city = City::factory()->create();

        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('hotel.register_submit'), [
                'name' => 'Hotel Tester',
                'email' => 'hotel@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'phone' => '0123456789',
                'address' => '123 Hotel St.',
                'city_id' => $city->id,
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'hotel@example.com',
            'role' => 'hotel',
        ]);

        Event::assertDispatched(Registered::class);

        $response->assertRedirect(route('hotel.dashboard'));
    }
    
    public function test_login_with_valid_credentials()
    {
        
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user = User::factory()->create([
            'role' => 'hotel',
        ]);

        $response = $this->post('/login', [
            'login' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('hotel.dashboard'));
    }

    public function test_login_with_invalid_credentials()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $response = $this->post(route('hotel.login_submit'), [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect(route('hotel.login'));
        $response->assertSessionHas('error');
    }

    public function test_hotel_logout()
    {
        $city = City::factory()->create();

        $user = User::factory()->create([
            'role' => 'hotel',
            'city_id' => $city->id,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('hotel.logout'));

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_hotel_profile_view()
    {
        $city = City::factory()->create();

        $user = User::factory()->create([
            'role' => 'hotel',
            'city_id' => $city->id,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('hotel.profile'));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.hotel_profile_view');
        $response->assertViewHas('profileData');
    }

    public function test_change_password_invalid_old()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $city = City::factory()->create();

        $hotel = User::factory()->create([
            'password' => bcrypt('oldpassword'),
            'city_id' => $city->id,
            'role' => 'hotel',
        ]);

        $this->actingAs($hotel, 'hotel');

        $response = $this->post(route('hotel.password.update'), [
            'old_password' => 'wrongpassword',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        $response->assertSessionHas([
            'message' => 'Mật khẩu cũ không khớp!',
            'alert-type' => 'error',
        ]);
    }

    public function test_change_password_valid()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $city = City::factory()->create();
        $user = User::factory()->create([
            'password' => bcrypt('oldpassword'),
            'role' => 'hotel',
            'city_id' => $city->id,
        ]);

        $this->actingAs($user, 'hotel');

        $response = $this->post(route('hotel.password.update'), [
            'old_password' => 'oldpassword',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        $response->assertSessionHas('message', 'Đổi mật khẩu thành công!');
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }
}
