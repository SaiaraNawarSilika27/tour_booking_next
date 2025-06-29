<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $package->name }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js'])
</head>
<body class="antialiased bg-gradient-to-b from-purple-300 via-purple-220 to-white text-gray-800 font-sans">

    <div class="container mx-auto py-6 px-4">

        @if (session('success'))
            <div class="alert alert-success text-purple-700">
                {{ session('success') }}
            </div>
        @endif
        @if (session('info'))
            <div class="alert alert-info text-purple-600">
                {{ session('info') }}
            </div>
        @endif

        <h1 class="text-3xl font-bold text-center text-purple-700 mb-6">{{ $package->name }}</h1>

        <div class="card bg-white shadow-lg p-6 mb-6">
            <div class="flex flex-col items-center">
                @if ($package->image)
                    <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="w-64 h-48 object-cover mb-4 rounded">
                @else
                    <img src="https://via.placeholder.com/256x192" alt="Placeholder" class="w-64 h-48 object-cover mb-4 rounded">
                @endif

                <p class="text-purple-700 mb-2">{{ $package->description }}</p>
                <p class="text-lg font-semibold text-purple-800">Price: ${{ $package->price }} per person</p>

                <div class="flex space-x-4 mt-4">
                    <a href="{{ route('home') }}" class="btn btn-outline border-purple-500 text-purple-600 hover:bg-purple-100">Back to Packages</a>
                    @auth
                        <form action="{{ route('wishlist.add', $package->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline border-purple-500 text-purple-600 hover:bg-purple-100">
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
                                Add to Wishlist
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>

        <div class="card bg-white shadow-lg p-6">
            <h3 class="text-xl font-bold text-purple-700 mb-4">Book This Package</h3>

            @auth
            
                <form action="{{ route('packages.book.submit', $package->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="user_name" class="input input-bordered bg-purple-200 border-purple-400 w-full" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" class="input input-bordered bg-purple-200 border-purple-400 w-full" value="{{ auth()->user()->email }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone" class="input input-bordered bg-purple-200 border-purple-400 w-full" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Booking Date</label>
                        <input type="date" name="booking_date" class="input input-bordered bg-purple-200 border-purple-400 w-full" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Number of Persons</label>
                        <input type="number" name="persons" class="input input-bordered text-white border-purple-200 w-full" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary bg-purple-600 hover:bg-purple-700 w-full mt-4">Book Now</button>
                </form>

                <form action="{{ route('customer.logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-error w-full">Logout</button>
                </form>

            @else
                <p class="text-center text-gray-600 mb-4">
                    Please 
                    <a href="{{ route('customer.login') }}" class="text-purple-600 underline hover:text-purple-800 transition">login</a> 
                    or 
                    <a href="{{ route('customer.register') }}" class="text-purple-600 underline hover:text-purple-800 transition">register</a> 
                    to book this package.
                </p>
            @endauth

            <p class="text-sm text-gray-500 text-center mt-4">
                Current Date & Time: {{ date('l, F j, Y, g:i A T') }} ({{ date('e') }})
            </p>
        </div>
    </div>
</body>
</html>
