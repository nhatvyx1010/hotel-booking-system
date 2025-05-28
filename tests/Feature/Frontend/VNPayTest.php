<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;

class VnpayTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    public function setUp(): void
    {
        parent::setUp();

        // Tạo user admin và đăng nhập
        $this->adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($this->adminUser);

        // Bỏ middleware VerifyCsrfToken
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    public function test_create_redirects_to_vnpay()
    {
        $room = Room::factory()->create(['price' => 100000, 'discount' => 10]);

        $postData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'country' => 'Vietnam',
            'phone' => '0123456789',
            'address' => '123 Street',
            'state' => 'Hanoi',
            'payment_method' => 'VNPAY',
            'total_price' => 1000000,
        ];

        // Thêm server biến REMOTE_ADDR rõ ràng ở đây
        $response = $this->withServerVariables([
            'REMOTE_ADDR' => '127.0.0.1',
        ])->post('/create-payment', $postData);

        $response->assertRedirect();

        $redirectUrl = $response->headers->get('Location');

        $this->assertStringContainsString('sandbox.vnpayment.vn', $redirectUrl);
        $this->assertStringContainsString('vnp_SecureHash=', $redirectUrl);
    }

    public function test_return_vnpay_success_creates_booking()
    {
        $room = Room::factory()->create(['price' => 100000, 'discount' => 0]);

        // Giả lập dữ liệu book_date trong session
        Session::put('book_date', [
            'room_id' => $room->id,
            'check_in' => now()->addDay()->format('Y-m-d'),
            'check_out' => now()->addDays(3)->format('Y-m-d'),
            'number_of_rooms' => 1,
            'persion' => 2,
        ]);

        $checkoutData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'country' => 'Vietnam',
            'phone' => '0123456789',
            'address' => '123 Street',
            'state' => 'Hanoi',
            'payment_method' => 'VNPAY',
        ];

        // Giả lập session checkout_data
        session(['checkout_data' => $checkoutData]);

        $response = $this->get('/return-vnpay?vnp_ResponseCode=00&name=Test User&email=test@example.com&country=Vietnam&phone=0123456789&address=123 Street&state=Hanoi&payment_method=VNPAY');

        $response->assertRedirect('/');
        $response->assertSessionHas('message', 'Đặt phòng thành công');
        $response->assertSessionHas('alert-type', 'success');

        $this->assertDatabaseHas('bookings', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'payment_status' => 1,
            'payment_method' => 'Thanh toán bằng VNPay',
        ]);
    }

    public function test_return_vnpay_failure_redirects_with_error()
    {
        $response = $this->get('/return-vnpay?vnp_ResponseCode=01');

        $response->assertRedirect('/');
        $response->assertSessionHas('error', 'Thanh toán thất bại!');
    }
}
