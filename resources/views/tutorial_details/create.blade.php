@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-2">Tambah Detail Tutorial</h1>
    <p class="text-gray-700 mb-4">
        <strong>Judul:</strong> {{ $tutorial->title }}<br>
        <strong>Kode Mata Kuliah:</strong> {{ $tutorial->kode_makul }}<br>
        <strong>Nama Mata Kuliah:</strong> {{ $namaMakul }}
    </p>

    <form method="POST" action="{{ route('details.store', $tutorial->id) }}" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf

        <div>
            <label class="block font-medium">Text</label>
            <textarea name="text" class="w-full border p-2 rounded" rows="4">{{ old('text') }}</textarea>
        </div>

        <div>
            <label class="block font-medium">Gambar</label>
            <input type="file" name="image" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium">Code</label>
            <textarea name="code" class="w-full border p-2 rounded" rows="4">{{ old('code') }}</textarea>
        </div>

        <div>
            <label class="block font-medium">URL Tambahan</label>
            <input type="url" name="url" class="w-full border p-2 rounded" value="{{ old('url') }}">
        </div>

        <div>
            <label class="block font-medium">Order</label>
            <input type="number" name="order" class="w-full border p-2 rounded" value="{{ old('order', 1)}}"  min="1">
        </div>

        <!--<div>
            <label class="block font-medium">Status</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="show">Show</option>
                <option value="hide" selected>Hide</option>
            </select>
        </div>-->

        <div class="text-right">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Simpan Detail
            </button>
        </div>
    </form>
</div>
@endsection
