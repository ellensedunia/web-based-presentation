<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)     //proses login
    {
        $response = Http::post('https://jwt-auth-eight-neon.vercel.app/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);
        
        if ($response->successful()) {
            $token = $response->json()['refreshToken'];
            $payload = $this->decodeJwtPayload($token);
        
            Session::put('refreshToken', $token);
            Session::put('user_email', $payload['email']); 
        
            return redirect()->route('admin.dashboard');
        }
        

        return back()->withErrors(['login' => 'Email atau password salah.']);
    }
    private function decodeJwtPayload($token)
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;
        }
    
        $payload = $parts[1];
        $decoded = base64_decode(strtr($payload, '-_', '+/'));
    
        return json_decode($decoded, true);
    }
    
    public function logout()    //proses logout
    {
        $token = Session::get('refreshToken');
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://jwt-auth-eight-neon.vercel.app/logout'); 
    
        if ($response->successful() && $response->body() === 'OK') {
            Session::flush();
            return redirect()->route('login')->with('status', 'Logout berhasil.');
        }
    
        Session::flush(); // fallback
        return redirect()->route('login')->with('status', 'Logout lokal berhasil (token server ditolak).');
    }
    

    

}
