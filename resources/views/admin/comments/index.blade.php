<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
 <nav class="bg-gradient-to-r from-orange-600 to-red-600 text-white shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Kiri: Judul -->
            <div class="flex items-center space-x-6">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
            </div>

            <!-- Tombol Hamburger (Muncul di Mobile) -->
            <button id="menu-toggle" class="md:hidden focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Menu Desktop -->
            <div class="hidden md:flex space-x-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="hover:bg-orange-700 px-4 py-2 rounded transition {{ request()->routeIs('admin.dashboard') ? 'bg-orange-700' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.candidates') }}"
                    class="hover:bg-orange-700 px-4 py-2 rounded transition {{ request()->routeIs('admin.candidates*') ? 'bg-orange-700' : '' }}">
                    Kelola Kandidat
                </a>
                <a href="{{ route('admin.comments.index') }}"
                    class="hover:bg-orange-700 px-4 py-2 rounded transition {{ request()->routeIs('admin.comments*') ? 'bg-orange-700' : '' }}">
                    Komentar
                </a>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div id="mobile-menu" class="hidden flex-col space-y-2 pb-4 md:hidden">
            <a href="{{ route('admin.dashboard') }}"
                class="block hover:bg-orange-700 px-4 py-2 rounded transition {{ request()->routeIs('admin.dashboard') ? 'bg-orange-700' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.candidates') }}"
                class="block hover:bg-orange-700 px-4 py-2 rounded transition {{ request()->routeIs('admin.candidates*') ? 'bg-orange-700' : '' }}">
                Kelola Kandidat
            </a>
            <a href="{{ route('admin.comments.index') }}"
                class="block hover:bg-orange-700 px-4 py-2 rounded transition {{ request()->routeIs('admin.comments*') ? 'bg-orange-700' : '' }}">
                Komentar
            </a>
        </div>
    </div>
</nav>

<!-- JS Toggle Menu -->
<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>



               
            </div>
        </div>
    </nav>
    {{-- isi dari orang yang komentar --}}
  <div class="overflow-x-auto mt-6 px-4 sm:px-6">
    <div class="bg-white shadow-xl rounded-lg p-4">
        {{-- Pesan sukses dan info --}}
        <div class="mb-4">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 shadow-md mt-3 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('info'))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-md shadow-md mt-3">
                    {{ session('info') }}
                </div>
            @endif
        </div>

        {{-- Tombol Reset dan Export --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-3 space-y-2 sm:space-y-0 mb-4">
            <form action="{{ route('admin.comments.reset') }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus semua komentar?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow-md transition">
                    🔄 Reset Semua Komentar
                </button>
            </form>
            <a href="{{ route('admin.comments.export') }}"
                class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-md transition text-center">
                📥 Export Komentar
            </a>
        </div>

        {{-- Tabel responsif --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gradient-to-r from-orange-600 to-red-600 text-white text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Nama User</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Kandidat</th>
                        <th class="px-4 py-3 text-left">Komentar</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Tanggal</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($comments as $comment)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $comment->user->name ?? 'Anonim' }}
                            </td>
                            <td class="px-4 py-3">{{ $comment->candidate->name ?? '-' }}</td>
                            <td class="px-4 py-3 max-w-xs break-words">
                                {{ $comment->message }}
                            </td>
                            <td class="px-4 py-3 text-gray-500 whitespace-nowrap">
                                {{ $comment->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs sm:text-sm transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-6">
                                Belum ada komentar dari user.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

    <!-- Main Content -->
    <main class="flex-1 mt-6">
        <div class="container mx-auto px-4">
            @yield('content')
        </div>
    </main>

</body>

</html>
