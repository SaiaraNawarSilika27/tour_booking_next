<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Package</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 text-gray-900 font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold text-center mb-6">Edit Package</h1>
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="card bg-white shadow-md p-6">
            <form action="{{ route('packages.update', $package->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" class="input input-bordered text-white w-full @error('name') input-error @enderror" value="{{ old('name', $package->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" class="textarea textarea-bordered text-white w-full @error('description') textarea-error @enderror" required>{{ old('description', $package->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" step="0.01" class="input input-bordered text-white w-full @error('price') input-error @enderror" value="{{ old('price', $package->price) }}" required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" class="file-input file-input-bordered text-white w-full @error('image') file-input-error @enderror">
                    @if ($package->image)
                        <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="w-32 h-32 object-cover mt-2">
                    @endif
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @endif
                </div>
                <button type="submit" class="btn btn-success w-full">Update</button>
            </form>
        </div>
        <p class="text-sm text-gray-500 text-center mt-4">Current Date & Time: {{ date('l, F j, Y, g:i A T') }} ({{ date('e') }})</p>
    </div>
</body>
</html>
