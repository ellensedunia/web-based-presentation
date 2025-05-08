@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Detail Tutorial: {{ $tutorial->title }}</h1>
        <a href="{{ route('details.create', $tutorial->id) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            Tambah Detail
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Text</th>
                    <th class="px-4 py-2">Gambar</th>
                    <th class="px-4 py-2">Code</th>
                    <th class="px-4 py-2">URL</th>
                    <th class="px-4 py-2">Order</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($details as $i => $detail)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $i + 1 }}</td>
                        <td class="px-4 py-2">{{ Str::limit($detail->text, 50) }}</td>
                        <td class="px-4 py-2">
                            @if ($detail->image)
                                <img src="{{ asset('storage/' . $detail->image) }}" class="h-16">
                            @endif
                        </td>
                        <td class="px-4 py-2"><code class="text-xs">{{ Str::limit($detail->code, 40) }}</code></td>
                        <td class="px-4 py-2">
                            @if ($detail->url)
                                <a href="{{ $detail->url }}" target="_blank" class="text-blue-600 underline">Link</a>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $detail->order }}</td>
                        <td class="px-4 py-2">
                            <form method="POST" action="{{ route('details.update', [$tutorial->id, $detail->id]) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="toggle_status" value="1">
                                <button type="submit"
                                    class="px-3 py-1 rounded text-white text-sm {{ $detail->status === 'show' ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-600 hover:bg-gray-700' }}">
                                    {{ $detail->status === 'show' ? 'Show' : 'Hide' }}
                                </button>
                                <input type="hidden" name="status" value="{{ $detail->status === 'show' ? 'hide' : 'show' }}">
                            </form>
                        </td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('details.edit', [$tutorial->id, $detail->id])  }}" class="bg-blue-500 hover:bg-blue-700 px-3 py-1 rounded text-white text-sm">
                            Edit </a>
                            <form method="POST" action="{{ route('details.destroy', [$tutorial->id, $detail->id]) }}" class="inline" onsubmit="return confirm('Hapus detail ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 px-3 py-1 rounded text-white text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500">Belum ada detail</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
