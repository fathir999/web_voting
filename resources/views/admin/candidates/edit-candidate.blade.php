<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kandidat - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    @include('layouts.admin-nav')

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Edit Kandidat</h1>
                <p class="text-gray-600">Update data kandidat</p>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-md p-6">
                <form method="POST" action="{{ route('admin.candidates.update', $candidate) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Nama Kandidat
                        </label>
                        <input 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name', $candidate->name) }}"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="photo">
                            Foto Kandidat
                        </label>
                        @if($candidate->photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->name }}" class="w-32 h-32 rounded object-cover">
                            </div>
                        @endif
                        <input 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="photo" 
                            type="file" 
                            name="photo" 
                            accept="image/*">
                        <p class="text-gray-500 text-xs mt-1">Kosongkan jika tidak ingin mengubah foto</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="vision">
                            Visi
                        </label>
                        <textarea 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="vision" 
                            name="vision" 
                            rows="3">{{ old('vision', $candidate->vision) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="mission">
                            Misi
                        </label>
                        <textarea 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="mission" 
                            name="mission" 
                            rows="3">{{ old('mission', $candidate->mission) }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ $candidate->is_active ? 'checked' : '' }} class="mr-2">
                            <span class="text-gray-700 text-sm font-bold">Kandidat Aktif</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.candidates') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            type="submit">
                            Update Kandidat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>