<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Homepage Public Tutorial</title>
    @vite('resources/css/app.css')
    <meta http-equiv="refresh" content="10">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div class="text-xl font-bold text-gray-800 flex items-center gap-2">
            Web Based Presentation App
        </div>
        <div>
            <a href="/login" class="bg-blue-700 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded flex items-center gap-1 text-sm">
               Login Admin
            </a>
        </div>
    </nav>

    <!-- Konten -->
    <main class="p-6 max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
             Daftar Tutorial 
        </h1>

        @if($tutorials->count())
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($tutorials as $t)
                    <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition-all">
                        <h2 class="text-lg font-bold text-blue-700 mb-1">{{ $t->title }}</h2>
                        <p class="text-sm text-gray-600 mb-1">
                            <i class="fas fa-book mr-1"></i> Kode MK: {{ $t->kode_makul }}
                        </p>
                        <p class="text-sm text-gray-600 mb-1">
                            <i class="fas fa-user mr-1"></i> Kreator: {{ $t->creator_email }}
                        </p>
                        <p class="text-xs text-gray-400 mb-4">
                            <i class="fas fa-clock mr-1"></i> {{ $t->created_at->diffForHumans() }}
                        </p>
                        
                        <div class="flex justify-between gap-2 text-sm">
                        <a href="{{ route('public.presentation', ['slug' => Str::slug($t->title), 'unique_filename' => $t->unique_filename]) }}"
                               class="flex-1 text-center bg-blue-100 text-blue-700 px-3 py-2 rounded hover:bg-blue-200 transition-all">
                               <i class="fa-regular fa-folder-open"></i> Lihat Tutorial
                            </a>
                         
                            @if($t->status === 'show')
                                <a href="{{ route('public.finished', ['slug' => Str::slug($t->title), 'unique_filename_finished' => $t->unique_filename_finished]) }}"
                                class="flex-1 text-center bg-green-100 text-green-700 px-3 py-2 rounded hover:bg-green-200 transition-all">
                                <i class="fa-regular fa-share-from-square"></i> Download PDF
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-5 rounded shadow">
                <h3 class="font-bold text-lg mb-1">
                    <i class="fas fa-info-circle mr-1"></i> Belum ada materi
                </h3>
                <p class="text-sm">Silakan cek secara berkala</p>
            </div>
        @endif
    </main>

</body>
</html>