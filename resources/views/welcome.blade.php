<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tour Booking</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js'])
</head>
<body class="antialiased bg-cover bg-center h-full bg-[url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e')] text-gray-900 font-sans">
    <!-- Navigation Bar -->
    <nav class="navbar bg-base-200 shadow-md p-4">
        <div class="navbar-start">
            <a href="{{ route('home') }}" class="btn btn-ghost text-yellow-300 text-xl">Tour Booking</a>
        </div>
        <div class="navbar-end">
             <a href="{{ route('wishlist')}}" class="text-white hover:text-red-400 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     fill="currentColor" 
                     viewBox="0 0 24 24" 
                     stroke-width="1.5" 
                     stroke="currentColor" 
                     class="w-8 h-8">
                    <path stroke-linecap="round" 
                          stroke-linejoin="round" 
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                </svg>
            </a>
            

            @auth
                <form action="{{ route('customer.logout') }}" method="POST" class="mr-4">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-error">Logout</button>
                </form>
            @else
                <a href="{{ route('customer.login') }}" class="btn btn-sm btn-info mr-2">Login</a>
                <a href="{{ route('customer.register') }}" class="btn btn-sm btn-success">Register</a>
            @endauth
        </div>
    </nav>
    <!-- Success Message -->
@if (session('success'))
    <div class="max-w-2xl mx-auto bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded shadow mb-6 text-center">
        {{ session('success') }}
    </div>
@endif

    <!-- Header -->
    <h1 class="text-center text-2xl font-bold p-6">Tour Packages</h1>

    <!-- Cards Section -->
    <div class="container mx-auto p-4">
        @if ($packages->isEmpty())
            <p class="text-center text-gray-600">No packages available.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($packages as $package)
                    <div class="card w-64 bg-base-100 shadow-xl">
                        <figure class="overflow-hidden">
                            @if ($package->image)
                                <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="w-full h-40 object-cover" />
                            @else
                                <img src="https://via.placeholder.com/150" alt="Placeholder" class="w-full h-40 object-cover" />
                            @endif
                        </figure>
                        <div class="card-body p-4">
                            <h2 class="card-title text-base text-gray-900">Title: {{ $package->name }}</h2>
                            <p class="text-sm text-gray-600">Price: ${{ $package->price }}</p>
                            <p class="text-sm text-gray-600">Description: {{ Str::limit($package->description, 100) }}</p>
                            <div class="card-actions justify-end">
                                <a href="{{ route('packages.show', $package->id) }}" class="btn btn-sm btn-primary">View & Book</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="footer footer-center p-4 bg-base-200 text-base-content mt-6">
        <p class="text-sm text-gray-500">Current Date & Time: {{ date('l, F j, Y, g:i A T') }} ({{ date('e') }})</p>
    </footer>
</body>
</html>
