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

    public function create(Tutorial $tutorial)
    {
        $token = Session::get('refreshToken');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://jwt-auth-eight-neon.vercel.app/getMakul');
    
        $mataKuliah = $response->successful() ? ($response->json()['data'] ?? []) : [];
    
        $namaMakul = collect($mataKuliah)->firstWhere('kdmk', $tutorial->kode_makul)['nama'] ?? '-';
    
        return view('tutorial_details.create', compact('tutorial', 'namaMakul'));
    }

    public function store(Request $request, Tutorial $tutorial)
    {
        $data = $request->validate([
            'text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'code' => 'nullable|string',
            'url' => 'nullable|url',
            'order' => 'nullable|integer|min:1',
            'status' => 'required|in:show,hide',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tutorial_images', 'public');
        }
        $detail = new TutorialDetail();
        $detail->tutorial_id = $tutorial->id;
        $detail->kode_makul = $tutorial->kode_makul; // opsional kalau disimpan
        $detail->text = $request->text;
        $data['tutorial_id'] = $tutorial->id;

        TutorialDetail::create($data);

        return redirect()->route('details.index', $tutorial->id)->with('success', 'Detail tutorial ditambahkan.');
    }

    public function edit(Tutorial $tutorial, TutorialDetail $detail)
    {
        $token = Session::get('refreshToken');

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->get('https://jwt-auth-eight-neon.vercel.app/getMakul');

    $mataKuliah = $response->successful() ? ($response->json()['data'] ?? []) : [];
    $namaMakul = collect($mataKuliah)->firstWhere('kdmk', $tutorial->kode_makul)['nama'] ?? '-';

    return view('tutorial_details.edit', compact('tutorial', 'detail', 'namaMakul'));
    }

    public function update(Request $request, Tutorial $tutorial, TutorialDetail $detail)
    {
        $data = $request->validate([
            'text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'code' => 'nullable|string',
            'url' => 'nullable|url',
            'order' => 'nullable|integer|min:1',
            'status' => 'required|in:show,hide',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($detail->image) {
                Storage::disk('public')->delete($detail->image);
            }
            $data['image'] = $request->file('image')->store('tutorial_images', 'public');
        }

        $detail->update($data);

        return redirect()->route('details.index', $tutorial->id)->with('success', 'Detail tutorial diperbarui.');
    }

    public function destroy(Tutorial $tutorial, TutorialDetail $detail)
    {
        if ($detail->image) {
            Storage::disk('public')->delete($detail->image);
        }

        $detail->delete();

        return redirect()->route('details.index', $tutorial->id)->with('success', 'Detail tutorial dihapus.');
    }
}
