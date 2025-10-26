<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kandidat - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    @include('layouts.admin-nav')

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Tambah Kandidat Baru</h1>
                <p class="text-gray-600">Isi form untuk menambahkan kandidat</p>
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
                <form method="POST" action="{{ route('admin.candidates.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Nama Kandidat
                        </label>
                        <input 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama kandidat" 
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="photo">
                            Foto Kandidat
                        </label>
                        <input 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="photo" 
                            type="file" 
                            name="photo" 
                            accept="image/*">
                        <p class="text-gray-500 text-xs mt-1">Format: JPG, PNG (Max: 2MB)</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="vision">
                            Visi
                        </label>
                        <textarea 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="vision" 
                            name="vision" 
                            rows="3"
                            placeholder="Masukkan visi kandidat">{{ old('vision') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="mission">
                            Misi
                        </label>
                        <textarea 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="mission" 
                            name="mission" 
                            rows="3"
                            placeholder="Masukkan misi kandidat">{{ old('mission') }}</textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.candidates') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            type="submit">
                            Simpan Kandidat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>