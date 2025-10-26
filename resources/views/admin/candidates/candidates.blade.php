<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kandidat - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    @include('layouts.admin-nav')

    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-800">Kelola Kandidat</h1>
                <p class="text-gray-600">CRUD Master Data Kandidat</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.candidates.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    + Tambah Kandidat
                </a>
                <a href="{{ route('admin.candidates.trashed') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                    🗑 Trash
                </a>

            </div>
        </div>





       

        
      @if(session('success'))
    <div class="mt-3 px-4 py-2 rounded font-semibold mb-3
        {{ Str::contains(session('success'), 'diaktifkan') 
            ? 'bg-green-500/20 text-green-800 border border-green-400' 
            : 'bg-red-500/20 text-red-800 border border-red-400' }}">
        {{ session('success') }}
    </div>
@endif



        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            {{-- overflow-x-auto jadi bisa scroll ketika sedang di mobile --}}
              <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visi</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Suara</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($candidates as $candidate)
                        <tr>
                            {{-- foto candidates --}}
                            <td class="px-6 py-4">
                                @if ($candidate->photo)
                                    <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->name }}"
                                        class="w-16 h-16 rounded-full object-cover">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                        <span class="text-gray-500 text-xl">{{ substr($candidate->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                {{-- nama candidate --}}
                                <div class="font-semibold text-gray-800">{{ $candidate->name }}</div>
                            </td>

                            <td class="px-6 py-4">
                                {{-- visi candidate --}}
                                <div class="text-sm text-gray-600">{{ Str::limit($candidate->vision, 50) }}</div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                {{-- suara candidate --}}
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-bold">
                                    {{ $candidate->vote_count }}
                                </span>
                            </td>
                            {{-- aktif dan nonaktif --}}
                            <td class="px-6 py-4 text-center">
                                @if ($candidate->status)
                                    <span
                                        class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Aktif</span>
                                @else
                                    <span
                                        class="bg-red-500/20 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Nonaktif</span>
                                @endif
                            </td>
                            {{-- edit dan hapus kandidat --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.candidates.edit', $candidate) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.candidates.delete', $candidate) }}"
                                        class="inline"
                                        onsubmit="return confirm('Yakin ingin membuang ke trash kandidat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.candidates.toggleStatus', $candidate->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin mengubah status kandidat ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="px-3 py-1 rounded text-white text-sm font-medium
                                {{ $candidate->status ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}">
                                            {{ $candidate->status ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Belum ada kandidat. <a href="{{ route('admin.candidates.create') }}"
                                    class="text-blue-500">Tambah kandidat</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
