<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use App\Models\TutorialDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TutorialDetailController extends Controller
{
    public function index(Tutorial $tutorial)
    {
        $details = $tutorial->details()->latest()->get();
        return view('tutorial_details.index', compact('tutorial', 'details'));
    }

    public function create(Tutorial $tutorial)      //create detail tutorial
    {
        $token = Session::get('refreshToken');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://jwt-auth-eight-neon.vercel.app/getMakul');
    
        $mataKuliah = $response->successful() ? ($response->json()['data'] ?? []) : [];
    
        $namaMakul = collect($mataKuliah)->firstWhere('kdmk', $tutorial->kode_makul)['nama'] ?? '-';
    
        return view('tutorial_details.create', compact('tutorial', 'namaMakul'));
    }

    public function store(Request $request, Tutorial $tutorial)     //simpan detail tutorial
    {
        $data = $request->validate([
            'text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'code' => 'nullable|string',
            'url' => 'nullable|url',
            'order' => 'nullable|integer|min:1',
            'status' => 'required|in:show,hide',
        ]);

        $data['tutorial_id'] = $tutorial->id;
        $data['kode_makul'] = $tutorial->kode_makul; // Pastikan kode_makul juga masuk ke $data

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tutorial_images', 'public');
        }

        TutorialDetail::create($data);

        return redirect()->route('details.index', $tutorial->id)->with('success', 'Detail tutorial ditambahkan.');
    }

    public function edit(Tutorial $tutorial, TutorialDetail $detail)    //edit detail tutorial
    {
        $token = Session::get('refreshToken');

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->get('https://jwt-auth-eight-neon.vercel.app/getMakul');

    $mataKuliah = $response->successful() ? ($response->json()['data'] ?? []) : [];
    $namaMakul = collect($mataKuliah)->firstWhere('kdmk', $tutorial->kode_makul)['nama'] ?? '-';

    return view('tutorial_details.edit', compact('tutorial', 'detail', 'namaMakul'));
    }

    public function update(Request $request, Tutorial $tutorial, TutorialDetail $detail)    //update detail tutorial
    {
        if ($request->has('toggle_status')) {
            $detail->status = $detail->status === 'show' ? 'hide' : 'show';
            $detail->save();
    
            return redirect()->route('details.index', $tutorial->id)->with('success', 'Status detail berhasil diubah.');
        }

        $data = $request->validate([
            'text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'code' => 'nullable|string',
            'url' => 'nullable|url',
            'order' => 'nullable|integer|min:1',
            'status' => 'required|in:show,hide',
        ]);

        if ($request->hasFile('image')) {
            //hapus gambar lama
            if ($detail->image) {
                Storage::disk('public')->delete($detail->image);
            }
            $data['image'] = $request->file('image')->store('tutorial_images', 'public');
        }

        $detail->update($data);

        return redirect()->route('details.index', $tutorial->id)->with('success', 'Detail tutorial diperbarui.');
    }

    public function destroy(Tutorial $tutorial, TutorialDetail $detail)     //hapus detal tutorial
    {
        if ($detail->image) {
            Storage::disk('public')->delete($detail->image);
        }

        $detail->delete();

        return redirect()->route('details.index', $tutorial->id)->with('success', 'Detail tutorial dihapus.');
    }
}
