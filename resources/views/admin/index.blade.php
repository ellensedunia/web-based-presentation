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
    <i class="fas fa-book-open mr-2 text-indigo-600"></i> Daftar Tutorial Publik
</h2>

@if ($tutorials->count())
    <ul class="space-y-4">
        @foreach ($tutorials as $t)
            <li class="bg-white p-4 rounded-lg shadow flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold text-indigo-700">{{ $t->title }}</h3>
                    <p class="text-sm text-gray-500">Kode MK: {{ $t->kode_makul }}</p>
                    <p class="text-sm text-gray-500">Creator: <span class="text-gray-700">{{ $t->creator_email }}</span></p>
                    <p class="text-xs text-gray-400">Dibuat: {{ $t->created_at->diffForHumans() }}</p>
                </div>
                <div class="text-right space-y-1">
                    <a href="{{ route('public.presentation', ['slug' => Str::slug($t->title), 'unique_filename' => $t->unique_filename]) }}" 
                       class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm hover:bg-blue-200">
                        <i class="fas fa-eye mr-1"></i> Lihat Tutorial
                    </a>
                    <a href="{{ route('public.finished', ['slug' => Str::slug($t->title), 'unique_filename_finished' => $t->unique_filename_finished]) }}"
                                class="flex-1 text-center bg-green-100 text-green-700 px-3 py-1 rounded hover:bg-green-200 transition-all">
                                    <i class="fas fa-file-pdf mr-1"></i> Download PDF
                                </a>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <div class="bg-yellow-100 text-yellow-800 border-l-4 border-yellow-400 p-4 rounded shadow">
        <p class="font-semibold">
            <i class="fas fa-exclamation-circle mr-2"></i>
            Maaf, belum ada materi tutorial yang tersedia saat ini.
        </p>
        <p class="text-sm">Silakan tambahkan materi.</p>
    </div>
@endif

    </div>
    <script>
    // Jika user tekan tombol back, browser akan reload dari server (bukan cache)
        // if (performance.navigation.type === 2) {
        //     window.location.href = "{{ route('login') }}"; // paksa redirect ke login
        // }
</script>

</body>
</html>
