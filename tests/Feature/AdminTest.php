<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use App\Models\City;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Tạo admin user để test
        $this->admin = User::factory()->create([
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    public function test_admin_dashboard_can_be_rendered()
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_admin_logout_redirects_to_login()
    {
        $response = $this->actingAs($this->admin)->get('/admin/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_admin_profile_update_with_photo()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('admin_photo.jpg');

        $response = $this->actingAs($this->admin)->post('/admin/profile/store', [
            'name' => 'New Admin Name',
            'email' => 'newadmin@example.com',
            'phone' => '0123456789',
            'address' => '123 Admin Street',
            'photo' => $file,
        ]);

        $response->assertSessionHas('message', 'Cập nhật hồ sơ quản trị viên thành công');

        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
            'name' => 'New Admin Name',
            'email' => 'newadmin@example.com',
        ]);
    }

    public function test_admin_password_update_success()
    {
        $response = $this->actingAs($this->admin)->post('/admin/password/update', [
            'old_password' => 'password123',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        $response->assertStatus(302); // redirect back sau khi đổi thành công

        $response->assertSessionHas('message', 'Đổi mật khẩu thành công');

        $this->assertTrue(Hash::check('newpassword123', $this->admin->fresh()->password));
    }

    public function test_create_new_admin_with_role()
    {
        $role = Role::create(['name' => 'manager']);
        $city = City::factory()->create();

        $response = $this->actingAs($this->admin)->post(route('store.admin'), [
            'name' => 'Test Admin',
            'email' => 'testadmin@example.com',
            'password' => 'admin123',
            'phone' => '0987654321',
            'address' => 'Admin Address',
            'city_id' => $city->id,
            'roles' => $role->id,
        ]);

        $response->assertRedirect(route('all.admin'));


        $response->assertRedirect(route('all.admin'));
        $this->assertDatabaseHas('users', [
            'email' => 'testadmin@example.com',
            'role' => 'admin',
        ]);
        $this->assertTrue(User::where('email', 'testadmin@example.com')->first()->hasRole('manager'));
    }

    public function test_update_existing_admin()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $role = Role::create(['name' => 'editor']);

        $response = $this->actingAs($user)->post(route('update.admin', ['id' => $user->id]), [
            'name' => 'Updated Admin Name',
            'email' => 'updatedadmin@example.com',
            'phone' => '1231231234',
            'address' => 'Updated Address',
            'roles' => $role->id,
        ]);

        $response->assertRedirect(route('all.admin'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'updatedadmin@example.com',
        ]);

        $this->assertTrue(User::find($user->id)->hasRole('editor'));
    }

    public function test_delete_admin()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($this->admin)->get("/delete/admin/{$user->id}");

        $response->assertRedirect();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
