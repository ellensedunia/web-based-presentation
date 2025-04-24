<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PublicTutorialController extends Controller
{
    // ✅ Halaman presentasi (auto refresh, hanya status 'show')
    public function showPresentation($slug, $unique_filename)
    {
        $tutorial = Tutorial::where('unique_filename', $unique_filename)
            ->where('title_slug', $slug)
            ->firstOrFail();
    
        $details = $tutorial->details()
            ->where('status', 'show')
            ->orderBy('order')
            ->get();
    
        return view('public.presentation', compact('tutorial', 'details'));
    }

    // ✅ Generate PDF dari semua detail tutorial (status 'show' dan 'hide')
    public function generatePdf($slug, $unique_filename_finished)
    {
        $tutorial = Tutorial::where('unique_filename_finished', $unique_filename_finished)
        ->where('title_slug', $slug)
        //->where('status', 'show')
        ->firstOrFail();

        $details = $tutorial->details()->orderBy('order')->get();

        $html = '<html><head><title>Tutorial PDF</title><style>
            body { font-family: sans-serif; font-size: 14px; }
            .section { margin-bottom: 20px; }
            .code-block { 
                background-color: #f4f4f4;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                margin-bottom: 10px;
                overflow-x: auto;
                font-family: monospace;
                font-size: 12px;
                white-space: pre-wrap;       /* Penting: mempertahankan format teks */
                word-break: break-all;       /* Opsional: memecah kata panjang */
            }
            .link-style {
                color: blue;
                text-decoration: underline;
            }
        </style></head><body>';
        $html .= '<h1>' . $tutorial->title . '</h1>';

        foreach ($details as $detail) {
            $html .= '<div class="section">';
            $html .= '<p>' . $detail->text . '</p>';
            if ($detail->image) {
                $imagePath = public_path('storage/' . $detail->image);
                $html .= '<img src="' . $imagePath . '" alt="Gambar Tutorial" style="max-width: 100%;">';
            }
            if ($detail->code) {
                $html .= '<div class="code-block"><strong>Code:</strong><br>' . htmlspecialchars($detail->code) . '</div>';
            }
            if ($detail->url) {
                $html .= '<p><strong>Link URL:</strong> <a href="' . $detail->url . '" class="link-style">' . $detail->url . '</a></p>';
            }
            $html .= '</div>';
        }

        $html .= '</body></html>';

        $pdf = Pdf::loadHtml($html);
        return $pdf->download("Tutorial - {$tutorial->title}.pdf");
    }
}

