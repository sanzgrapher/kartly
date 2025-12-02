<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $userLogin = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $guestSessionId = $request->session()->getId();

        $remember = $request->has('remember');

        if (Auth::attempt($userLogin, $remember)) {
            $request->session()->regenerate();

            $this->cartService->mergeGuestCart($guestSessionId);

            $user = Auth::user();

            $role = $user->role_name ?? null;

            if (is_string($role) && strtolower($role) === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
