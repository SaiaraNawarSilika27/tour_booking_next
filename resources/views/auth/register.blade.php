<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Register</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="card w-full max-w-md mx-auto bg-white shadow-md p-6">
            <h2 class="text-2xl font-semibold text-center mb-4">Customer Register</h2>
            @if ($errors->any())
                <div class="alert alert-error mb-4">
                    {{ implode('', $errors->all(':message')) }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('customer.register') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" class="input input-bordered w-full" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" class="input input-bordered w-full" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" class="input input-bordered w-full" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="input input-bordered w-full" required>
                </div>
                <button type="submit" class="btn btn-primary w-full">Register</button>
            </form>
            <p class="text-center mt-4">
                <a href="{{ route('customer.login') }}" class="text-blue-500">Login</a>
            </p>
        </div>
    </div>
</body>
</html>
