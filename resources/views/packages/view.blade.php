<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $package->name }} - View Details</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js'])
</head>
<body class="antialiased bg-gradient-to-b from-purple-300 via-purple-200 to-white text-gray-800 font-sans">
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Success and Info Messages -->
        @if (session('success'))
            <div class="alert alert-success bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded shadow mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif
        @if (session('info'))
            <div class="alert alert-info bg-blue-100 border border-blue-400 text-blue-800 px-4 py-3 rounded shadow mb-6 text-center">
                {{ session('info') }}
            </div>
        @endif

        <!-- Package Details Section -->
        <div class="card bg-white shadow-xl p-6 md:p-8 rounded-lg">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <!-- Left: Package Image -->
                <div class="md:w-1/2 w-full">
                    @if ($package->image)
                        <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="w-full h-80 md:h-96 object-cover rounded-lg shadow-md">
                    @else
                        <img src="https://via.placeholder.com/400x300?text=No+Image" alt="Placeholder" class="w-full h-80 md:h-96 object-cover rounded-lg shadow-md">
                    @endif
                </div>
                <!-- Right: Package Details -->
                <div class="md:w-1/2 w-full md:pl-6 flex flex-col justify-start">
                    <h1 class="text-3xl md:text-4xl font-bold text-purple-700 mb-4">{{ $package->name }}</h1>
                    <p class="text-lg font-semibold text-purple-800 mb-3">Price: ${{ number_format($package->price, 2) }} per person</p>
                    <p class="text-lg text-gray-700 mb-3">Duration: {{ $package->Duration ?? 'Not specified' }}</p>
                    <p class="text-gray-700 text-base mb-6 leading-relaxed">{{ $package->description }}</p>
                    <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
                        <a href="{{ route('home') }}" class="btn btn-outline border-purple-500 text-purple-600 hover:bg-purple-100 w-full sm:w-auto">Back to Packages</a>
                        <a href="{{ route('packages.show', $package->id) }}" class="btn btn-primary bg-purple-600 hover:bg-purple-700 text-white w-full sm:w-auto">View Full Details</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer footer-center p-4 bg-base-200 text-base-content mt-8 rounded">
            <p class="text-sm text-gray-500">Current Date & Time: {{ date('l, F j, Y, g:i A T') }} ({{ date('e') }})</p>
        </footer>
    </div>
</body>
</html>