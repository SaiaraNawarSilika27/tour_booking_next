<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Bookings</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js'])
</head>
<body class="antialiased bg-gradient-to-br from-blue-50 to-indigo-100 text-gray-900 font-sans">
    <div class="container mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-center mb-8 text-indigo-700 bg-indigo-100 py-4 rounded-lg shadow-md">Admin - Booking List</h1>
        <div class="card bg-white shadow-xl p-6 rounded-lg border border-gray-200">
            @if ($bookings->isEmpty())
                <p class="text-center text-yellow-600 bg-yellow-50 p-4 rounded-md">No bookings found.</p>
            @else
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                            <th class="text-left p-3">ID</th>
                            <th class="text-left p-3">User Name</th>
                            <th class="text-left p-3">Email</th>
                            <th class="text-left p-3">Phone</th>
                            <th class="text-left p-3">Date</th>
                            <th class="text-left p-3">Persons</th>
                            <th class="text-left p-3">Package</th>
                            <th class="text-left p-3">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition duration-200 border-b border-gray-200">
                                <td class="p-3 text-indigo-700 font-medium">{{ $booking->id }}</td>
                                <td class="p-3 text-green-700">{{ $booking->user_name }}</td>
                                <td class="p-3 text-blue-700">{{ $booking->email }}</td>
                                <td class="p-3 text-purple-700">{{ $booking->phone }}</td>
                                <td class="p-3 text-teal-700">{{ $booking->booking_date }}</td>
                                <td class="p-3 text-orange-700">{{ $booking->persons }}</td>
                                <td class="p-3 text-pink-700">{{ $booking->package->name ?? 'N/A' }}</td>
                                <td class="p-3 text-red-700 font-semibold">{{ $booking->total_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
           <a href="{{ route('admin.dashboard') }}" class="btn btn-outline btn-info mt-4">Back to Dashboard</a>
        </div>
        <p class="text-sm text-gray-600 text-center mt-6 bg-gray-50 p-2 rounded-md">Current Date & Time: {{ date('l, F j, Y, g:i A T') }} ({{ date('e') }})</p>
    </div>
</body>
</html>