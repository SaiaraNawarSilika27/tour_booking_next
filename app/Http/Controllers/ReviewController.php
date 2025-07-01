<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Package;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Package $package)
    {
        $request->validate([
            'review' => 'required|string|max:1000',
        ]);

         // Check if user has booked this package
        if (!Booking::where('user_id', Auth::id())->where('package_id', $package->id)->exists()) {
            return redirect()->route('packages.view', $package->id)->with('info', 'You can only review packages you have booked.');
        }

        // Check if user has already reviewed this package
        if (Review::where('user_id', Auth::id())->where('package_id', $package->id)->exists()) {
            return redirect()->route('packages.view', $package->id)->with('info', 'You have already reviewed this package.');
        }

        Review::create([
            'package_id' => $package->id,
            'user_id' => Auth::id(),
            'review' => $request->review,
        ]);

        return redirect()->route('packages.view', $package->id)->with('success', 'Review submitted successfully!');
    }
}