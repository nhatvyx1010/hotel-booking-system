<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'user',
        ]);

        $this->adminUser = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    /** @test */
    public function it_can_store_a_comment()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->actingAs($this->user);
        $user = User::factory()->create();
        $post = BlogPost::factory()->create();

        $data = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'message' => 'This is a test comment.',
        ];

        $response = $this->post(route('store.comment'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Bình luận đã được thêm, quản trị viên sẽ duyệt');

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'message' => 'This is a test comment.',
        ]);
    }

    /** @test */
    public function it_can_list_all_comments()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->actingAs($this->adminUser);

        $comment = Comment::factory()->create();

        $response = $this->get(route('all.comment'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.comment.all_comment');
        $response->assertViewHas('allcomment', function ($comments) use ($comment) {
            return $comments->contains($comment);
        });
    }

    /** @test */
    public function it_can_update_comment_status()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->actingAs($this->adminUser);

        $comment = Comment::factory()->create(['status' => 0]);

        $response = $this->post(route('update.comment.status'), [
            'comment_id' => $comment->id,
            'is_checked' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Cập nhật trạng thái bình luận thành công']);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'status' => 1,
        ]);
    }
}
