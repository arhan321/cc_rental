<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
     public function home()
    {
        $user = Auth::user();
        return view('frontend.home', compact('user'));
    }

    public function pengajuan()
    {
        $user = Auth::user();
        return view('frontend.pengajuan', compact('user'));
    }

    public function pesanan()
    {
        $user = Auth::user();
        return view('frontend.pesanan', compact('user'));
    }

    public function pesananresep()
    {
        $user = Auth::user();
        return view('frontend.pesananresep', compact('user'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('frontend.profile', compact('user'));
    }

    
public function register(Request $request)
{
    $validated = $request->validate([
    'nama_lengkap' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|string|min:6|confirmed',
    'tanggal_lahir' => 'required|date',
    'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
    'nomor_telepon' => 'required|string|max:20', 
]);

    $user = User::create([
        'name' => $validated['nama_lengkap'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    Profile::create([
    'user_id' => $user->id,
    'nama_lengkap' => $validated['nama_lengkap'],
    'tanggal_lahir' => $validated['tanggal_lahir'],
    'jenis_kelamin' => $validated['jenis_kelamin'],
    'nomor_telepon' => $validated['nomor_telepon'], 
    ]);

    Auth::login($user);

    return response()->json([
        'success' => true,
        'redirect' => '/',
    ]);
}
}
