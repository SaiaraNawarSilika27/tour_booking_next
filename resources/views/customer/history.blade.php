<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking History - Tour Booking</title>
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
                <a href="{{ route('customer.history') }}" class="btn btn-sm btn-primary mr-2">View Buying History</a>
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

    <!-- Header -->
    <h1 class="text-center text-2xl font-bold p-6">Your Booking History</h1>

    <!-- Table Section -->
    <div class="container mx-auto p-4">
        @if ($bookings->isEmpty())
            <p class="text-center text-gray-600">You have no booking history.</p>
        @else
            <div class="overflow-x-auto">
                <table class="table w-full bg-white shadow-xl rounded-lg">
                    <thead>
                        <tr class="bg-base-200">
                            <th class="p-4 text-left">Image</th>
                            <th class="p-4 text-left">Title</th>
                            <th class="p-4 text-left">Price</th>
                            <th class="p-4 text-left">Duration</th>
                            <th class="p-4 text-left">Booked On</th>
                            <th class="p-4 text-left">Description</th>
                            <th class="p-4 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            @if ($booking->package)
                                <tr class="hover:bg-purple-200">
                                    <td class="p-4">
                                        <a href="{{ route('packages.view', $booking->package->id) }}">
                                            @if ($booking->package->image)
                                                <img src="{{ asset('storage/' . $booking->package->image) }}" alt="{{ $booking->package->name }}" class="w-16 h-16 object-cover rounded-lg" />
                                            @else
                                                <img src="https://via.placeholder.com/150" alt="Placeholder" class="w-16 h-16 object-cover rounded-lg" />
                                            @endif
                                        </a>
                                    </td>
                                    <td class="p-4">
                                        <a href="{{ route('packages.view', $booking->package->id) }}" class="text-blue-600 hover:underline">
                                            {{ $booking->package->name }}
                                        </a>
                                    </td>
                                    <td class="p-4">${{ $booking->package->price }}</td>
                                    <td class="p-4">{{ $booking->package->Duration ?? 'N/A' }}</td>
                                    <td class="p-4">{{ $booking->created_at->format('F j, Y') }}</td>
                                    <td class="p-4">{{ Str::limit($booking->package->description, 100) }}</td>
                                    <td class="p-4">
                                        <button onclick="toggleReviewForm('review-form-{{ $booking->package->id }}')" class="btn btn-sm btn-primary">Write a Review</button>
                                        <div id="review-form-{{ $booking->package->id }}" class="hidden mt-2">
                                            <form action="{{ route('reviews.store', $booking->package->id) }}" method="POST">
                                                @csrf
                                                <textarea name="review" class="textarea bg-white  textarea-bordered w-full" placeholder="Write your review here..." required></textarea>
                                                <button type="submit" class="btn btn-sm btn-success mt-2">Submit Review</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="footer footer-center p-4 bg-base-200 text-base-content mt-6">
        <p class="text-sm text-gray-500">Current Date & Time: {{ date('l, F j, Y, g:i A T') }} ({{ date('e') }})</p>
    </footer>

    <!-- JavaScript for toggling review form -->
    <script>
        function toggleReviewForm(formId) {
            const form = document.getElementById(formId);
            form.classList.toggle('hidden');
        }
    </script>
</body>
</html>