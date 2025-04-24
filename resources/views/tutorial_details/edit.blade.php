@extends('layouts.app')

@section('content')

<div class="p-6 max-w-3xl mx-auto">
<h1 class="text-2xl font-bold mb-6">Edit Detail Tutorial: 
    <span class="text-indigo-600">{{ $tutorial->title }}</span>
</h1>
<p class="text-sm text-gray-700 mb-4">
   
    <strong>Nama Mata Kuliah:</strong> {{ $namaMakul }}
</p>
    <a href="{{ route('details.index', $tutorial->id) }}"
       class="text-sm text-blue-600 hover:underline mb-4 inline-block"> Kembali ke Detail Tutorial</a>

    <form method="POST" action="{{ route('details.update', [$tutorial->id, $detail->id]) }}" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium mb-1">Text</label>
            <textarea name="text" class="w-full border p-2 rounded" rows="4">{{ old('text', $detail->text) }}</textarea>
        </div>

        <div>
            <label class="block font-medium mb-1">Gambar Saat Ini</label><br>
            @if ($detail->image)
                <img src="{{ asset('storage/' . $detail->image) }}" class="h-24 mb-2 rounded shadow">
            @else
                <p class="text-sm text-gray-500">Belum ada gambar.</p>
            @endif
            <input type="file" name="image" class="w-full border rounded p-2 mt-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Code</label>
            <textarea name="code" class="w-full border p-2 rounded" rows="4">{{ old('$tutorial->kode_makul ', $detail->code) }}</textarea>
        </div>

        <div>
            <label class="block font-medium mb-1">URL Tambahan</label>
            <input type="url" name="url" class="w-full border p-2 rounded" value="{{ old('url', $detail->url) }}">
        </div>

        <div>
            <label class="block font-medium mb-1">Order</label>
            <input type="number" name="order" class="w-full border p-2 rounded" value="{{ old('order', $detail->order) }}">
        </div>

        <!--<div>
            <label class="block font-medium mb-1">Status</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="show" {{ $detail->status === 'show' ? 'selected' : '' }}>Show</option>
                <option value="hide" {{ $detail->status === 'hide' ? 'selected' : '' }}>Hide</option>
            </select>
        </div> -->

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Update Detail
            </button>
        </div>
    </form>
</div>
@endsection
