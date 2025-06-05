<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
        */
        public function store(LoginRequest $request): RedirectResponse
        {
            $request->authenticate();

            $id = Auth::user()->id;
            $profileData = User::find($id);

            // ✅ Kiểm tra: nếu là tài khoản khách sạn (hotel) và đang chờ phê duyệt
            if ($profileData->role === 'hotel' && $profileData->status === 'pending' || $profileData->status === 'cancelled') {
                Auth::logout(); // Huỷ đăng nhập
                return redirect()->back()
                    ->with('message', 'Tài khoản khách sạn của bạn đang chờ phê duyệt. Vui lòng quay lại sau.')
                    ->with('alert-type', 'error');
            }

            $request->session()->regenerate();
            
            $username = $profileData->name;

            $notification = array(
                'message' => 'Người dùng '.$username.' đã đăng nhập thành công',
                'alert-type' => 'info'
            );
            // return redirect()->back()->with('message', 'User '.$username.' Login Successfully')->with('alert-type', 'info');

            $url = '';
            if($request->user()->role === 'admin'){
                $url = '/admin/dashboard';
            }elseif($request->user()->role === 'hotel'){
                $url = '/hotel/dashboard';
            }elseif($request->user()->role === 'user'){
                $url = '/profile';
            }

            return redirect()->intended($url)->with('message', 'Người dùng '.$username.' đã đăng nhập thành công')->with('alert-type', 'info');
        }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
