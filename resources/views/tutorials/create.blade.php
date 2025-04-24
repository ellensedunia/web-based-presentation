@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tambah Tutorial</title>
    @vite('resources/css/app.css')
</head>
<body class="p-8 bg-gray-50">
    <h1 class="text-2xl font-bold mb-4">Tambah Tutorial Baru</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
            <ul class="list-disc pl-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tutorials.store') }}" method="POST" class="space-y-4 bg-white p-4 rounded shadow max-w-xl">
        @csrf
        <input name="title" placeholder="Judul Tutorial" required
               value="{{ old('title') }}"
               class="w-full border px-3 py-2 rounded" />

        <select name="kode_makul" required class="w-full border px-3 py-2 rounded">
            <option value="">Pilih Mata Kuliah</option>
            @foreach ($mataKuliah ?? [] as $makul)
                <option value="{{ $makul['kdmk'] }}"
                        {{ old('kode_makul') == $makul['kdmk'] ? 'selected' : '' }}>
                    {{ $makul['nama'] ?? 'Mata Kuliah Tidak Dikenal' }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Simpan
        </button>
        <a href="{{ route('tutorials.index') }}" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Kembali</a>
    </form>
</body>
</html>

@endsection
