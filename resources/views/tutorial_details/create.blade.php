@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tambah Detail Tutorial</title>
    @vite('resources/css/app.css')
</head>
<body class="p-8 bg-gray-50">
    <h1 class="text-2xl font-bold mb-4">Tambah Detail Tutorial</h1>
    <p class="text-gray-700 mb-4">
        <strong>Judul:</strong> {{ $tutorial->title }}<br>
        <strong>Kode Mata Kuliah:</strong> {{ $tutorial->kode_makul }}<br>
        <strong>Nama Mata Kuliah:</strong> {{ $namaMakul }}
    </p>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
            <ul class="list-disc pl-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('details.store', $tutorial->id) }}" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf

        <div>
            <label for="text" class="block font-medium">Text</label>
            <textarea id="text" name="text" class="w-full border px-3 py-2 rounded" rows="4">{{ old('text') }}</textarea>
        </div>

        <div>
            <label for="image" class="block font-medium">Gambar</label>
            <input type="file" id="image" name="image" class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label for="code" class="block font-medium">Code</label>
            <textarea id="code" name="code" class="w-full border px-3 py-2 rounded" rows="4">{{ old('code') }}</textarea>
        </div>

        <div>
            <label for="url" class="block font-medium">URL Tambahan</label>
            <input type="url" id="url" name="url" class="w-full border px-3 py-2 rounded" value="{{ old('url') }}">
        </div>

        <div>
            <label for="order" class="block font-medium">Order</label>
            <input type="number" id="order" name="order" class="w-full border px-3 py-2 rounded" value="{{ old('order', 1) }}" min="1">
        </div>

        <!<div>
            <label for="status" class="block font-medium">Status</label>
            <select id="status" name="status" class="w-full border px-3 py-2 rounded">
                <option value="show">Show</option>
                <option value="hide" selected>Hide</option>
            </select>
        </div>

        <div class="text-right">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Simpan Detail
            </button>
            <a href="{{ route('details.index', $tutorial->id) }}" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Kembali</a>
        </div>
    </form>
</body>
</html>
@endsection
