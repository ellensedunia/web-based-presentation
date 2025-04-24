@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Daftar Tutorial</h1>
        <a href="{{ route('tutorials.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            Tambah Tutorial
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-gray-100 text-left text-sm uppercase tracking-wider">
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Kode MK</th>
                <th class="px-4 py-2">Mata Kuliah</th>
                <th class="px-4 py-2">Judul</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">PDF</th>
                <th class="px-4 py-2">URL Present</th>
                <th class="px-4 py-2">URL Finished</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tutorials as $i => $t)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2">{{ $i + 1 }}</td>
                <td class="px-4 py-2">{{ $t->kode_makul }}</td>
                <td class="px-4 py-2">
                    {{ collect($mataKuliah)->firstWhere('kdmk', $t->kode_makul)['nama'] ?? '-' }}
                </td>
                <td class="px-4 py-2">{{ $t->title }}</td>
                <td class="px-4 py-2">
                    <span class="inline-block px-2 py-1 rounded text-white text-xs {{ $t->status === 'hide' ? 'bg-yellow-500' : 'bg-green-600' }}">
                        {{ ucfirst($t->status ?? 'show') }}
                    </span>
                </td>
                <td class="px-4 py-2">
                    <form action="{{ route('tutorials.update', $t->id) }}" method="POST" onsubmit="return confirm('Ubah status tutorial ini?')">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="toggle_status" value="1">
                        <input type="hidden" name="status" value="{{ $t->status }}">
                        <button class="px-3 py-1 rounded text-white text-sm {{ $t->status == 'hide' ? 'bg-green-600 hover:bg-green-700' : 'bg-yellow-500 hover:bg-yellow-600' }}">
                            {{ $t->status == 'hide' ? 'Show' : 'Hide' }}
                        </button>
                    </form>
                </td>
                <td class="px-4 py-2 space-x-2">
                    
                    <a href="{{ route('public.presentation', ['slug' => Str::slug($t->title), 'unique_filename' => $t->unique_filename]) }}"
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">
                        Presentation
                    </a>
                   
                </td>
                <td class="px-4 py-2">
                    
                    <a href="{{ route('public.finished', ['slug' => Str::slug($t->title), 'unique_filename_finished' => $t->unique_filename_finished]) }}"
                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs">
                        PDF
                    </a>
                   
                </td>
                <td class="px-4 py-2 space-x-2">
                    <a href="{{ route('tutorials.edit', $t->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">
                        Edit
                    </a>
                    <form action="{{ route('tutorials.destroy', $t->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus tutorial ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">Delete</button>
                    </form>
                    <a href="{{ route('details.index', $t->id) }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-1 px-2 rounded text-xs">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
