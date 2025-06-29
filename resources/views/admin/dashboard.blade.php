<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js'])
</head>
<body class="antialiased bg-white text-gray-900">

    <!-- Logout Button -->
    <form method="POST" action="{{ route('admin.logout') }}" class="absolute top-4 right-4">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline btn-error">Logout</button>
    </form>

    <h1 class="text-center text-2xl font-bold p-6">Admin Dashboard</h1>

    <div class="container mx-auto p-4 flex justify-center">
        <div class="flex gap-4 mb-6">
            <button id="toggleAddPackageForm" class="btn btn-primary">Add Package</button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-info">View Bookings</a>
        </div>
    </div>

    <!-- Add Package Form Section -->
    <div class="container mx-auto p-4" id="addPackageForm" style="display: none;">
        <div class="card bg-white shadow-md p-6">
            <h3 class="font-bold text-lg mb-4">Add New Package</h3>
            @if (session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4" id="packageForm">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-black">Name</label>
                    <input type="text" name="name" class="input input-bordered text-white w-full @error('name') input-error @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-black">Description</label>
                    <textarea name="description" class="textarea textarea-bordered text-white w-full @error('description') textarea-error @enderror" required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-black">Price</label>
                    <input type="number" name="price" step="0.01" class="input input-bordered text-white w-full @error('price') input-error @enderror" value="{{ old('price') }}" required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-black">Image</label>
                    <input type="file" name="image" class="file-input file-input-bordered text-white w-full @error('image') file-input-error @enderror" id="imageInput" accept="image/*">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @endif
                    <div id="imagePreview" class="mt-2 hidden">
                        <img id="previewImage" class="w-32 h-32 object-cover rounded" alt="Image Preview">
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-outline" id="closeAddPackageForm">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container mx-auto p-4">
        <h2 class="text-xl font-semibold mb-4 text-center">Packages</h2>
        @if ($packages->isEmpty())
            <p class="text-center text-gray-600">No packages available.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($packages as $package)
                    <div class="card w-64 bg-base-100 shadow-xl">
                        <div class="card-body p-4">
                            <figure class="overflow-hidden">
                            @if ($package->image)
                                <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="w-full h-40 object-cover" />
                            @else
                                <img src="https://via.placeholder.com/150" alt="Placeholder" class="w-full h-40 object-cover" />
                            @endif
                        </figure>
                            <h2 class="card-title text-base text-white">Title: {{ $package->name }}</h2>
                            <p class="text-sm text-white">Price: ${{ $package->price }}</p>
                            <div class="card-actions justify-end gap-2">
                                <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('packages.destroy', $package->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-error" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        // Form toggle and image preview functionality
        const toggleButton = document.getElementById('toggleAddPackageForm');
        const formSection = document.getElementById('addPackageForm');
        const closeButton = document.getElementById('closeAddPackageForm');
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');

        toggleButton.addEventListener('click', function() {
            formSection.style.display = formSection.style.display === 'none' ? 'block' : 'none';
        });

        closeButton.addEventListener('click', function() {
            formSection.style.display = 'none';
        });

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add('hidden');
            }
        });
    </script>

    <p class="text-sm text-gray-500 text-center mt-4">Current Date & Time: {{ date('l, F j, Y, g:i A T') }} ({{ date('e') }})</p>
</body>
</html>
