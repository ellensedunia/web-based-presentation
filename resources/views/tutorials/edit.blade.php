@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Edit Tutorial</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
            <ul class="list-disc pl-6">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tutorials.update', $tutorial->id) }}" method="POST" class="space-y-4 bg-white p-4 rounded shadow">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-sm font-medium">Judul</label>
            <input type="text" name="title" id="title"
                   value="{{ old('title', $tutorial->title) }}"
                   required class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label for="kode_makul" class="block text-sm font-medium">Mata Kuliah</label>
            <select name="kode_makul" id="kode_makul" class="w-full border px-3 py-2 rounded" required>
                <option value="">Pilih Mata Kuliah</option>
                @foreach ($mataKuliah ?? [] as $makul)
                    <option value="{{ $makul['kdmk'] }}" {{ $tutorial->kode_makul == $makul['kdmk'] ? 'selected' : '' }}>
                        {{ $makul['nama'] ?? 'Tidak Dikenal' }}
                    </option>
                @endforeach
            </select>
        </div>
        <!--
        <div>
            <label for="url_presentation" class="block text-sm font-medium">URL Presentation</label>
            <input type="url" name="url_presentation" id="url_presentation"
                   value="{{ old('url_presentation', $tutorial->url_presentation) }}"
                   required class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label for="url_finished" class="block text-sm font-medium">URL Finished</label>
            <input type="url" name="url_finished" id="url_finished"
                   value="{{ old('url_finished', $tutorial->url_finished) }}"
                   required class="w-full border px-3 py-2 rounded">
        </div>
        -->
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan Perubahan
        </button>
        <a href="{{ route('tutorials.index') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Batal</a>
    </form>
</div>
@endsection
