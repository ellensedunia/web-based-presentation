<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TutorialController extends Controller
{
    public function adminDashboard()    //tampil dashboard admin
    {
        $tutorials = Tutorial::latest()->get();

        $token = Session::get('refreshToken');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://jwt-auth-eight-neon.vercel.app/getMakul');

        $mataKuliah = $response->successful() ? ($response->json()['data'] ?? []) : [];

        return view('admin.index', compact('tutorials', 'mataKuliah'));
    }

    public function index()     //tampil daftar tutorial
    {
        $tutorials = Tutorial::latest()->get();
        $token = Session::get('refreshToken');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://jwt-auth-eight-neon.vercel.app/getMakul');

        $mataKuliah = $response->successful() ? ($response->json()['data'] ?? []) : [];

        return view('tutorials.index', compact('tutorials', 'mataKuliah'));
    }

    public function create()    //form crrate new tutorial
    {
        $token = Session::get('refreshToken');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://jwt-auth-eight-neon.vercel.app/getMakul');

        $mataKuliah = $response->successful() ? ($response->json()['data'] ?? []) : [];

        return view('tutorials.create', compact('mataKuliah'));
    }

    public function store(Request $request)     //store ke db
    {
        $request->validate([
            'title' => 'required',
            'kode_makul' => 'required',
        ]);

        $tutorial = new Tutorial();
        $tutorial->title = $request->title;
        $tutorial->kode_makul = $request->kode_makul;
        $tutorial->unique_filename = Str::uuid(); //generate UUID for unique filename
        $tutorial->unique_filename_finished = Str::uuid();
        $tutorial->url_presentation = 'presentation/' . $tutorial->unique_filename; //simpan dengan unique_filename
        $tutorial->url_finished = 'finished/' . $tutorial->unique_filename_finished;     //simpan dengan unique_filename
        $tutorial->creator_email = session('user_email');
        $tutorial->save();

        return redirect()->route('tutorials.index')->with('success', 'Tutorial berhasil ditambahkan.');
    }

    public function destroy(Tutorial $tutorial)     //hapus tutorial
    {
        $tutorial->delete();
        return redirect()->back()->with('success', 'Tutorial dihapus');
    }

    public function update(Request $request, Tutorial $tutorial)    //update tutorial
    {
        if ($request->has('toggle_status')) {
            $tutorial->status = $tutorial->status === 'show' ? 'hide' : 'show';
            $tutorial->save();

            return redirect()->route('tutorials.index')->with('success', 'Status tutorial berhasil diubah.');
        }

        $request->validate([ //ditambahkan validasi
            'title' => 'required',
            'kode_makul' => 'required',
        ]);

        //jika update field lain
        $tutorial->title = $request->title;
        $tutorial->kode_makul = $request->kode_makul;
        if (!$tutorial->unique_filename) {
            $tutorial->unique_filename = Str::uuid();
            $tutorial->url_presentation = 'presentation/' . $tutorial->unique_filename;
            $tutorial->url_finished = 'finished/' . $tutorial->unique_filename;
        }
       
        $tutorial->save();

        return redirect()->route('tutorials.index')->with('success', 'Tutorial berhasil diupdate.');
    }

    public function edit(Tutorial $tutorial)    //edit tutorial
    {
        $token = Session::get('refreshToken');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://jwt-auth-eight-neon.vercel.app/getMakul');

        $mataKuliah = $response->successful() ? ($response->json()['data'] ?? []) : [];

        return view('tutorials.edit', compact('tutorial', 'mataKuliah'));
    }
    
}

