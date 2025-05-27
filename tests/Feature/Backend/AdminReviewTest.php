<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Review;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_all_reviews(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        
        Review::factory()->count(3)->create();

        $response = $this
            ->actingAs($admin)
            ->get('/all/review');

        $response->assertOk();
    }

    /** @test */
    public function it_updates_review_status_successfully()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $admin = User::factory()->create(['role' => 'admin']);

        $review = Review::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($admin)->post('/update/review/status', [
            'review_id' => $review->id,
            'status' => 'approved',
        ]);

        $response->assertJson(['message' => 'Cập nhật trạng thái đánh giá thành công']);
        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'status' => 'approved',
        ]);
    }

    /** @test */
    public function it_rejects_invalid_review_status_update()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $admin = User::factory()->create(['role' => 'admin']);
        $review = Review::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($admin)->post('/update/review/status', [
            'review_id' => $review->id,
            'status' => 'invalid-status',
        ]);

        $response->assertStatus(400);
        $response->assertJson(['message' => 'Dữ liệu không hợp lệ']);
    }

    /** @test */
    public function it_stores_a_new_review()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $user = User::factory()->create();
        $booking = Booking::factory()->create();

        $response = $this->actingAs($user)->post('/reviews/store', [
            'hotel_id' => $user->id,
            'booking_id' => $booking->id,
            'comment' => 'Very good service',
            'rating' => 5,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'booking_id' => $booking->id,
            'comment' => 'Very good service',
            'rating' => 5,
            'status' => 'approved',
        ]);
    }

}
