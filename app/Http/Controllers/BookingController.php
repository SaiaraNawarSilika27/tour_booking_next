<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Show booking form for a specific package
    public function create($id)
    {
        $package = Package::findOrFail($id);
        return view('bookings.create', compact('package'));
    }

    // Store booking in the database
    public function store(Request $request, $id)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'booking_date' => 'required|date',
            'persons' => 'required|integer|min:1',
        ]);

        $package = Package::findOrFail($id);
        $totalPrice = $package->price * $request->persons;

        Booking::create([
            'user_name' => $request->user_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'booking_date' => $request->booking_date,
            'persons' => $request->persons,
            'package_id' => $id,
            'user_id' => Auth::check() ? Auth::id() : null,
            'total_price' => $totalPrice,
        ]);

        return redirect()->route('home')->with('success', 'Booking successful!');
    }

    // Show all bookings in admin panel
    public function index()
    {
        $bookings = Booking::all();
        return view('admin.bookings.index', compact('bookings'));
    }
}
