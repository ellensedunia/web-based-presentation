<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CheckPdfStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Mendapatkan slug dan unique_filename_finished dari route
        $slug = $request->route('slug');
        $uniqueFilenameFinished = $request->route('unique_filename_finished');

        // Mengambil data tutorial berdasarkan slug dan unique_filename_finished
        $tutorial = \App\Models\Tutorial::where('unique_filename_finished', $uniqueFilenameFinished)->first();

        // Memeriksa apakah tutorial ditemukan dan status PDF adalah "show"
        if ($tutorial && $tutorial->pdf_status === 'show') {
            return $next($request); // Lanjutkan jika status "show"
        }

        // Jika status bukan "show", redirect ke halaman lain atau tampilkan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki izin untuk mengakses PDF ini.'); // Redirect ke home dengan pesan error
    }
}