<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_can_store_blog_category()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->actingAs($this->adminUser);

        $response = $this->post(route('store.blog.category'), [
            'category_name' => 'Tin tức',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('blog_categories', [
            'category_slug' => 'tin-tuc',
        ]);
    }

    public function test_can_update_blog_category()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->actingAs($this->adminUser);

        $category = BlogCategory::factory()->create([
            'category_name' => 'Cũ',
        ]);

        $response = $this->post(route('update.blog.category'), [
            'cat_id' => $category->id,
            'category_name' => 'Mới',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('blog_categories', [
            'id' => $category->id,
            'category_name' => 'Mới',
        ]);
    }

    public function test_can_delete_blog_category()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->actingAs($this->adminUser);

        $category = BlogCategory::factory()->create();

        $response = $this->get(route('delete.blog.category', $category->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('blog_categories', [
            'id' => $category->id,
        ]);
    }


    public function test_can_store_blog_post()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        Storage::fake('public');

        $user = User::factory()->create();
        $category = BlogCategory::factory()->create();

        $this->actingAs($this->adminUser);

        $response = $this->post(route('store.blog.post'), [
            'blogcat_id' => $category->id,
            'post_title' => 'Bài viết mới',
            'short_desc' => 'Mô tả ngắn',
            'long_desc' => 'Mô tả dài',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('blog_posts', [
            'post_title' => 'Bài viết mới',
            'post_slug' => 'bai-viet-moi',
            'short_desc' => 'Mô tả ngắn',
        ]);
    }

    public function test_can_update_blog_post_without_image()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->actingAs($this->adminUser);

        $user = User::factory()->create();
        $category = BlogCategory::factory()->create();

        $post = BlogPost::factory()->create([
            'user_id' => $user->id,
            'blogcat_id' => $category->id,
        ]);

        $response = $this->post(route('update.blog.post'), [
            'id' => $post->id,
            'blogcat_id' => $category->id,
            'post_title' => 'Tiêu đề mới',
            'short_desc' => 'Mô tả ngắn mới',
            'long_desc' => 'Mô tả dài mới',
        ]);

        $response->assertRedirect(route('all.blog.post'));
        $this->assertDatabaseHas('blog_posts', ['post_title' => 'Tiêu đề mới']);
    }
}
