<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div class="flex items-center space-x-6">
            <h1 class="text-xl font-bold">Halaman Admin</h1>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('tutorials.index') }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                Kelola Tutorial
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Logout</button>
            </form>
        </div>
    </nav>

    <div class="p-8">
        <h2 class="text-2xl font-bold mb-4">Manajemen Tutorial</h2>
        <h2 class="text-xl font-bold mb-6 text-gray-800">
</h2>

@if ($tutorials->count())
    <ul class="space-y-4">
        @foreach ($tutorials as $t)
            <li class="bg-white p-4 rounded-lg shadow flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-bold text-black-700">{{ $t->title }}</h3>
                    <p class="text-sm text-gray-700">Kode MK: {{ $t->kode_makul }}</p>
                    <p class="text-sm text-gray-700">Kreator: {{ $t->creator_email }}</p>
                    <p class="text-xs text-gray-500">Dibuat: {{ $t->created_at->diffForHumans() }}</p>
                </div>
                <div class="text-right space-y-1">
                    <a href="{{ route('public.presentation', ['slug' => Str::slug($t->title), 'unique_filename' => $t->unique_filename]) }}" 
                       class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm hover:bg-blue-200">
                       <i class="fa-regular fa-folder-open"></i> Lihat Tutorial
                    </a>
                    <a href="{{ route('public.finished', ['slug' => Str::slug($t->title), 'unique_filename_finished' => $t->unique_filename_finished]) }}"
                        class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded text-sm hover:bg-blue-200">
                        <i class="fa-regular fa-share-from-square"></i> Download PDF
                        </a>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <div class="bg-yellow-100 text-yellow-800 border-l-4 border-yellow-400 p-4 rounded shadow">
        <p class="font-semibold">
            <i class="fas fa-exclamation-circle mr-2"></i>
            Belum ada materi tutorial yang tersedia
        </p>
        <p class="text-sm">Silakan tambahkan materi</p>
    </div>
@endif

    </div>
</body>
</html>
