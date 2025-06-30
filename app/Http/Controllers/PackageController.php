<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all(); // Fetch all packages (can be paginated as needed)
        return view('welcome', compact('packages')); // Updated to use welcome.blade.php
    }

    public function show($id)
    {
        $package = Package::findOrFail($id);
        return view('packages.show', compact('package')); // Returns the detailed package view
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'Duration' => 'required|string',
            'image' => 'nullable|image|max:2048', // Validate image file, max 2MB
        ]);

        $data = $request->only(['name', 'description', 'price', 'Duration']);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('packages', 'public');
            $data['image'] = $imagePath;
        }

        Package::create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Package added successfully!');
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'Duration' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'Duration']);
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($package->image) {
                Storage::disk('public')->delete($package->image);
            }
            $imagePath = $request->file('image')->store('packages', 'public');
            $data['image'] = $imagePath;
        }

        $package->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Package updated successfully!');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        if ($package->image) {
            Storage::disk('public')->delete($package->image);
        }
        $package->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Package deleted successfully!');
    }
    // Display a single package preview (for view.blade.php)
    public function view($id)
    {
        $package = Package::findOrFail($id);
        return view('packages.view', compact('package'));
    }
    
}
