<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tutorial;

class TutorialApiController extends Controller
{
    public function byMataKuliah($kode_makul)
    {
        $tutorials = Tutorial::where('kode_makul', $kode_makul)
            ->select('title', 'kode_makul', 'url_presentation', 'url_finished', 'creator_email', 'created_at', 'updated_at')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $tutorials
        ]);
    }
}
