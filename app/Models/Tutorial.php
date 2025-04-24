<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tutorial extends Model
{
    protected $fillable = [
        'title',
        'kode_makul',
        'url_presentation',
        'url_finished',
        'creator_email',
    ];

    public function details()
    {
        return $this->hasMany(TutorialDetail::class, 'tutorial_id');
    }

    public function showPresentation(Tutorial $tutorial)
    {
        $details = $tutorial->details()->where('status', 'show')->orderBy('order')->get();
        return view('public.presentation', compact('tutorial', 'details'));
    }

    public function mataKuliah()
    {
        return $this->belongsTo(Tutorial::class, 'kode_makul', 'kode_makul');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($tutorial) {
            $tutorial->title_slug = Str::slug($tutorial->title);
        });
    }

}
