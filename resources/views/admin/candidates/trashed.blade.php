<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash Kandidat - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    @include('layouts.admin-nav')

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Trash Kandidat</h1>

        <div class="bg-white rounded-lg shadow-md overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Suara</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Dihapus</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($candidates as $candidate)
                        <tr>
                            <td class="px-6 py-4">
                                @if($candidate->photo)
                                    <img src="{{ asset('storage/' . $candidate->photo) }}" alt="Foto Kandidat"
                                        class="w-12 h-12 object-cover rounded-full">
                                @else
                                    <span class="text-gray-400 text-sm">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $candidate->name }}</td>
                            <td class="px-6 py-4">{{ Str::limit($candidate->vision, 50) }}</td>
                            <td class="px-6 py-4 text-center">{{ $candidate->vote_count }}</td>
                            <td class="px-6 py-4">
                                @if($candidate->is_active)
                                    <span class="text-green-600 font-semibold">Aktif</span>
                                @else
                                    <span class="text-red-600 font-semibold">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $candidate->deleted_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <form method="POST"
                                        action="{{ route('admin.candidates.restore', $candidate->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                            Restore
                                        </button>
                                    </form>

                                    <form method="POST"
                                        action="{{ route('admin.candidates.force-delete', $candidate->id) }}"
                                        onsubmit="return confirm('Hapus permanen kandidat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                            Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada kandidat yang dihapus.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
