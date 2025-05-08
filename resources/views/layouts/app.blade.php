<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div class="font-bold text-lg">Halaman Admin</div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:underline">Dashboard</a>
            <a href="{{ route('tutorials.index') }}" class="text-gray-700 hover:underline">Tutorial</a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="text-red-500 hover:underline">Logout</button>
            </form>
        </div>
    </nav>

    <main class="p-6">
        @yield('content')
    </main>
    <script>
    // Jika user tekan tombol back, browser akan reload dari server (bukan cache)
    // if (performance.navigation.type === 2) {
    //     window.location.href = "{{ route('login') }}"; // paksa redirect ke login
    // }
</script>

</body>
</html>
