<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->with('error', 'Username tidak ditemukan.');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah.');
        }

        session([
            'login' => true,
            'user_id' => $user->id,
            'nama' => $user->nama,
            'departemen' => $user->departemen,
            'role' => $user->role,
        ]);

        // Redirect ke halaman sebelum login
        if (session()->has('redirect_after_login')) {

            $redirect = session('redirect_after_login');

            session()->forget('redirect_after_login');

            return redirect($redirect);
        }

        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect('/login');
    }
}