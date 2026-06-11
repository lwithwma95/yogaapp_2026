<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'state'    => redirect()->route('state.dashboard'),
                'district' => redirect()->route('district.dashboard'),
                'block'    => redirect()->route('block.dashboard'),
                'cadre'    => redirect()->route('cadre.dashboard'),
                default    => redirect('/'),
            };
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // ── CADRE LOGIN (member code, no password) ──────────────────────
        if ($request->filled('member_code')) {

            $request->validate([
                'member_code' => 'required|string',
            ]);

            $user = User::where('email', $request->member_code . '@asrlm.in')
                        ->where('role', 'cadre')
                        ->first();

            if (!$user) {
                return back()->withErrors([
                    'member_code' => 'Member code not registered. Contact your Block office.',
                ])->withInput();
            }

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('cadre.dashboard');
        }

        // ── BLOCK / DISTRICT / STATE LOGIN (email + password) ───────────
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Invalid credentials.']);
        }

        // First-time login — no password set yet
        if (empty($user->password)) {
            return redirect()->route('create.password', ['id' => $user->id]);
        }

        if (Auth::attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        )) {
            $request->session()->regenerate();

            return match ($user->role) {
                'state'    => redirect()->route('state.dashboard'),
                'district' => redirect()->route('district.dashboard'),
                'block'    => redirect()->route('block.dashboard'),
                default    => redirect()->intended('/'),
            };
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }
    public function createPassword($id)
    {
        $user = User::findOrFail($id);
        return view('auth.createpassword', compact('user'));
    }

    public function updatePassword(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:users,id',
            'newpassword' => 'required|min:8',
            'confirmed' => 'required|same:newpassword',
        ]);
        
        $user = User::findOrFail($request->id);

        $user->update([

            'password' => Hash::make($request->newpassword)

        ]);

        Auth::login($user);

        $request->session()->regenerate();

        switch ($user->role) {

            case 'state':

                return redirect()->route('state.dashboard')
                    ->with('success', 'Password Created Successfully');

            case 'district':

                return redirect()->route('district.dashboard')
                    ->with('success', 'Password Created Successfully');

            case 'block':

                return redirect()->route('block.dashboard')
                    ->with('success', 'Password Created Successfully');

            case 'cadre':

                return redirect()->route('cadre.dashboard')
                    ->with('success', 'Password Created Successfully');

            default:

                return redirect()->route('user.dashboard')
                    ->with('success', 'Password Created Successfully');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}