<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's wishlist.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $wishlist = Auth::user()->wishlist()->get();
        return view('wishlist', compact('wishlist'));
    }

    /**
     * Add a package to the user's wishlist.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Package $package)
    {
        $user = Auth::user();
        if (!$user->wishlist()->where('package_id', $package->id)->exists()) {
            $user->wishlist()->attach($package->id);
            return redirect()->back()->with('success', 'Package added to wishlist!');
        }
        return redirect()->back()->with('info', 'Package is already in your wishlist.');
    }

    /**
     * Remove a package from the user's wishlist.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Package $package)
    {
        Auth::user()->wishlist()->detach($package->id);
        return redirect()->back()->with('success', 'Package removed from wishlist.');
    }
}