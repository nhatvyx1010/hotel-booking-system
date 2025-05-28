<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Tạo admin user
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->hotelUser = User::factory()->create([
            'role' => 'hotel',
        ]);

        // Bỏ middleware VerifyCsrfToken
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        // Đăng nhập với adminUser
        $this->actingAs($this->adminUser);
    }

    /** @test */
    public function validate_booking_requires_booking_code_and_email()
    {
        $response = $this->post(route('validate.booking.for.review'), []);

        $response->assertSessionHasErrors(['booking_code', 'booking_email']);
    }

    /** @test */
    public function validate_booking_fails_if_no_matching_booking_found()
    {
        $response = $this->post(route('validate.booking.for.review'), [
            'booking_code' => 'NONEXIST',
            'booking_email' => 'email@example.com',
            'hotel_id' => 1,
        ]);

        $response->assertSessionHas('message', 'Không tìm thấy thông tin đặt phòng phù hợp, hoặc bạn không thuộc khách sạn này.');
        $response->assertSessionHas('alert-type', 'error');
    }

    /** @test */
    public function validate_booking_succeeds_and_sets_session_if_booking_exists()
    {
        $hotelUser = $this->adminUser;
        $room = Room::factory()->create(['hotel_id' => $hotelUser->id]);
        $booking = Booking::factory()->create([
            'code' => 'BOOK123',
            'email' => 'test@example.com',
            'check_out' => Carbon::yesterday()->toDateString(),
            'status' => '1',
            'rooms_id' => $room->id,
        ]);

        $response = $this->post(route('validate.booking.for.review'), [
            'booking_code' => $booking->code,
            'booking_email' => $booking->email,
            'hotel_id' => $hotelUser->id,
        ]);

        $response->assertSessionHas('canReview', true);
        $response->assertSessionHas('booking_id', $booking->id);
        $response->assertSessionHas('message', 'Tìm thấy thông tin đặt phòng phù hợp. Bạn có thể viết đánh giá.');
        $response->assertSessionHas('alert-type', 'success');
    }

    /** @test */
    public function review_store_requires_valid_data()
    {
        $response = $this->post(route('reviews.store'), []);

        $response->assertSessionHasErrors(['hotel_id', 'booking_id', 'rating', 'comment']);
    }

    /** @test */
    public function review_store_creates_review_and_clears_session()
    {
        $hotelUser = $this->adminUser;
        $room = Room::factory()->create(['hotel_id' => $hotelUser->id]);
        $booking = Booking::factory()->create([
            'rooms_id' => $room->id,
            'status' => '1',
        ]);

        $data = [
            'hotel_id' => $hotelUser->id,
            'booking_id' => $booking->id,
            'rating' => 4,
            'comment' => 'Great stay!',
        ];

        // Set session to simulate canReview
        session(['canReview' => true, 'booking_id' => $booking->id]);

        $response = $this->post(route('reviews.store'), $data);

        $this->assertDatabaseHas('reviews', [
            'hotel_id' => $hotelUser->id,
            'user_id' => $hotelUser->id,
            'booking_id' => $booking->id,
            'rating' => 4,
            'comment' => 'Great stay!',
        ]);

        $response->assertRedirect();
        $response->assertSessionMissing('canReview');
        $response->assertSessionMissing('booking_id');
        $response->assertSessionHas('success', 'Cảm ơn bạn đã đánh giá!');
    }

    /** @test */
    public function hotel_can_reply_review()
    {
        $this->actingAs($this->hotelUser);
        $user = User::factory()->create();

        $review = Review::factory()->create([
            'hotel_id' => $this->hotelUser->id, // sửa ở đây
            'user_id' => $user->id,
            'booking_id' => 1,
        ]);

        $response = $this->post(route('reviews.reply', ['id' => $review->id]), [
            'comment' => 'Thank you for your feedback!',
            'rating' => 0,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Phản hồi đã được gửi.');

        $this->assertDatabaseHas('reviews', [
            'parent_id' => $review->id,
            'hotel_id' => $review->hotel_id,
            'user_id' => $this->hotelUser->id,
            'comment' => 'Thank you for your feedback!',
        ]);
    }

    /** @test */
    public function hotel_cannot_reply_review_if_not_owner()
    {
        $otherHotelUser = User::factory()->create(['role' => 'admin']);
        $reviewer = User::factory()->create();

        $review = Review::factory()->create([
            'hotel_id' => $otherHotelUser->id,
            'user_id' => $reviewer->id,
            'booking_id' => 1,
        ]);

        $randomUser = User::factory()->create([
            'role' => 'hotel',
        ]);

        $this->actingAs($randomUser);

        $response = $this->post(route('reviews.reply', ['id' => $review->id]), [
            'comment' => 'Trying to reply',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function hotel_all_review_returns_view_with_reviews()
    {
        // Giả sử $this->adminUser là user có role hotel (hoặc tạo mới nếu chưa có)
        $this->actingAs($this->hotelUser);

        $review = Review::factory()->create([
            'hotel_id' => $this->hotelUser->id,
            'parent_id' => null,
        ]);

        $response = $this->get(route('hotel.all.review'));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.backend.review.all_review');
        $response->assertViewHas('allreview');
    }
}
