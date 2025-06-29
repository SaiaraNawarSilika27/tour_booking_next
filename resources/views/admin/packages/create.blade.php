<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Package</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 text-gray-900 font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold text-center mb-6">Add New Package</h1>
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="card bg-white shadow-md p-6">
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
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" class="textarea textarea-bordered text-white w-full @error('description') textarea-error @enderror" required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" step="0.01" class="input input-bordered text-white w-full @error('price') input-error @enderror" value="{{ old('price') }}" required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" class="file-input file-input-bordered text-white w-full @error('image') file-input-error @enderror" id="imageInput" accept="image/*">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @endif
                    <div id="imagePreview" class="mt-2 hidden">
                        <img id="previewImage" class="w-32 text-white h-32 object-cover rounded" alt="Image Preview">
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-full">Save</button>
            </form>
        </div>
        <p class="text-sm text-gray-500 text-center mt-4">Current Date & Time: {{ date('l, F j, Y, g:i A T') }} ({{ date('e') }})</p>
    </div>

    <script>
        // Image preview functionality
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');
            const previewImage = document.getElementById('previewImage');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
