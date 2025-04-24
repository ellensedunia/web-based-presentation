<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <form method="POST" action="/login" class="bg-white p-8 rounded shadow-md w-96">
        @csrf
        <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>
        
        @if (session('status'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('status') }}
    </div>
@endif

@if ($errors->has('logout'))
    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
        {{ $errors->first('logout') }}
    </div>
@endif


        <label class="block mb-2">Email</label>
        <input type="email" name="email" required class="w-full p-2 border rounded mb-4" />

        <label class="block mb-2">Password</label>
        <input type="password" name="password" required class="w-full p-2 border rounded mb-6" />

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Login</button>
    </form>
</body>
</html>
