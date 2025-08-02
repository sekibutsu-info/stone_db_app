<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

use App\Models\Notice;
use App\Models\User;
use App\Models\Suggestion;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login', [
          'notices' => Notice::whereNull('to_user')->get(),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $req_name = $request->only('name');
        $name = $req_name["name"];
        User::where('name', $name)->update(['last_login' => now()]);

        $request->session()->regenerate();

        // 提案があるときはダッシュボードを表示する
        $auth = Auth::user();
        $suggestions = Suggestion::where([['contributor_id',  $auth->id], ['closed', 0]])->count();
        if(0 < $suggestions) {
          return redirect('/dashboard');
        } else {
          return redirect()->intended(RouteServiceProvider::HOME);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
