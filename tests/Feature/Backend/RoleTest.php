<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PermissionImport;
use App\Exports\PermissionExport;
use Illuminate\Support\Facades\DB;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $this->actingAs($this->adminUser);
    }

    // ---------------------------
    // QUYỀN (Permission)
    // ---------------------------

    public function test_all_permission_view()
    {
        Permission::create(['name' => 'permission1', 'group_name' => 'group1']);
        Permission::create(['name' => 'permission2', 'group_name' => 'group2']);
        Permission::create(['name' => 'permission3', 'group_name' => 'group3']);

        $response = $this->get(route('all.permission'));

        $response->assertStatus(200)
                ->assertViewIs('backend.pages.permission.all_permission')
                ->assertViewHas('permissions'); // kiểm tra biến truyền view có tồn tại

        // Bạn có thể kiểm tra thêm nội dung trong view
        $permissions = $response->viewData('permissions');
        $this->assertCount(3, $permissions);
    }


    public function test_add_permission_view()
    {
        $response = $this->get(route('add.permission'));
        $response->assertStatus(200)->assertViewIs('backend.pages.permission.add_permission');
    }

    public function test_store_permission()
    {
        $response = $this->post(route('store.permission'), [
            'name' => 'edit articles',
            'group_name' => 'Articles',
        ]);

        $response->assertRedirect(route('all.permission'));
        $this->assertDatabaseHas('permissions', ['name' => 'edit articles']);
    }

    public function test_edit_permission_view()
    {
        $permission = Permission::create(['name' => 'permission1', 'group_name' => 'group1']);
        
        $response = $this->get(route('edit.permission', $permission->id));
        
        $response->assertStatus(200)
                ->assertViewIs('backend.pages.permission.edit_permission')
                ->assertViewHas('permission');  // kiểm tra biến permission được truyền view
    }

    public function test_update_permission()
    {
        $permission = Permission::create(['name' => 'permission1', 'group_name' => 'group1']);

        $response = $this->post(route('update.permission'), [
            'id' => $permission->id,
            'name' => 'new name',
            'group_name' => 'New Group',
        ]);

        $response->assertRedirect(route('all.permission'));

        $this->assertDatabaseHas('permissions', [
            'id' => $permission->id,
            'name' => 'new name',
            'group_name' => 'New Group',
        ]);
    }

    public function test_delete_permission()
    {
        $permission = Permission::create(['name' => 'permission1', 'group_name' => 'group1']);
        $response = $this->get(route('delete.permission', $permission->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('permissions', ['id' => $permission->id]);
    }

    public function test_import_permission_view()
    {
        $response = $this->get(route('import.permission'));
        $response->assertStatus(200)->assertViewIs('backend.pages.permission.import_permisson');
    }

    public function test_export_permission()
    {
        Excel::fake();
        $response = $this->get(route('export'));
        $response->assertStatus(200);
        Excel::assertDownloaded('permissions.xlsx');
    }

    public function test_import_permission()
    {
        Excel::fake();
        $file = UploadedFile::fake()->create('permissions.xlsx');

        $response = $this->post(route('import'), [
            'import_file' => $file,
        ]);

        $response->assertRedirect();
        Excel::assertImported('permissions.xlsx');
    }

    // ---------------------------
    // VAI TRÒ (Roles)
    // ---------------------------

    public function test_all_roles_view()
    {
        $role = Role::create([
            'name' => 'role1',
            'guard_name' => 'web',  // guard_name là trường bắt buộc theo migration của bạn
        ]);
        $response = $this->get(route('all.roles'));
        $response->assertStatus(200)->assertViewIs('backend.pages.roles.all_roles');
    }

    public function test_add_roles_view()
    {
        $response = $this->get(route('add.roles'));
        $response->assertStatus(200)->assertViewIs('backend.pages.roles.add_roles');
    }

    public function test_store_roles()
    {
        $response = $this->post(route('store.roles'), [
            'name' => 'Editor',
        ]);

        $response->assertRedirect(route('all.roles'));
        $this->assertDatabaseHas('roles', ['name' => 'Editor']);
    }

    public function test_edit_roles_view()
    {
        $role = Role::create([
            'name' => 'role1',
            'guard_name' => 'web',  // guard_name là trường bắt buộc theo migration của bạn
        ]);

        $response = $this->get(route('edit.roles', $role->id));

        $response->assertStatus(200)
                ->assertViewIs('backend.pages.roles.edit_roles');
    }

    public function test_update_roles()
    {
        $role = Role::create([
            'name' => 'role1',
            'guard_name' => 'web',
        ]);

        $response = $this->post(route('update.roles'), [
            'id' => $role->id,
            'name' => 'UpdatedRole',
            'guard_name' => 'web', // nhớ thêm guard_name nếu cần trong update
        ]);

        $response->assertRedirect(route('all.roles'));

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'UpdatedRole',
            'guard_name' => 'web',
        ]);
    }

    public function test_delete_roles()
    {
        $role = Role::create([
            'name' => 'role1',
            'guard_name' => 'web',
        ]);

        $response = $this->get(route('delete.roles', $role->id));

        $response->assertRedirect();

        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    public function test_add_roles_permission_view()
    {
        $response = $this->get(route('add.roles.permission'));
        $response->assertStatus(200)->assertViewIs('backend.pages.rolesetup.add_roles_permission');
    }

    public function test_role_permission_store()
    {
        $role = Role::create([
            'name' => 'role1',
            'guard_name' => 'web',
        ]);

        $permissions = collect([
            Permission::create(['name' => 'perm1', 'group_name' => 'group1']),
            Permission::create(['name' => 'perm2', 'group_name' => 'group1']),
        ]);

        $response = $this->post(route('role.permission.store'), [
            'role_id' => $role->id,
            'permission' => $permissions->pluck('id')->toArray(),
        ]);

        $response->assertRedirect(route('all.roles.permission'));

        foreach ($permissions as $perm) {
            $this->assertDatabaseHas('role_has_permissions', [
                'role_id' => $role->id,
                'permission_id' => $perm->id,
            ]);
        }
    }

    public function test_all_roles_permission_view()
    {
        $response = $this->get(route('all.roles.permission'));
        $response->assertStatus(200)->assertViewIs('backend.pages.rolesetup.all_roles_permission');
    }

    public function test_admin_edit_roles_view()
    {
        $role = Role::create([
            'name' => 'role1',
            'guard_name' => 'web',
        ]);

        $response = $this->get(route('admin.edit.roles', $role->id));

        $response->assertStatus(200)
                ->assertViewIs('backend.pages.rolesetup.edit_roles_permission');
    }

    public function test_admin_roles_update()
    {
        $role = Role::create([
            'name' => 'role1',
            'guard_name' => 'web',
        ]);

        $permissions = collect([
            Permission::create(['name' => 'perm1', 'group_name' => 'group1']),
            Permission::create(['name' => 'perm2', 'group_name' => 'group1']),
        ]);

        $response = $this->post(route('admin.roles.update', $role->id), [
            'permission' => $permissions->pluck('id')->toArray(),
        ]);

        $response->assertRedirect(route('all.roles.permission'));
        $this->assertTrue($role->fresh()->permissions->contains($permissions[0]));
    }

    public function test_admin_delete_roles()
    {
        $role = Role::create([
            'name' => 'role1',
            'guard_name' => 'web',
        ]);

        $response = $this->get(route('admin.delete.roles', $role->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

}
