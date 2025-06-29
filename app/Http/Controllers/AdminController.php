<?php

namespace App\Http\Controllers;
use App\Models\Package;

class AdminController extends Controller {
    public function index() {
        $packages = Package::all();
        return view('admin.dashboard', compact('packages'));
    }
}
