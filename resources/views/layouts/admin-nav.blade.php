<nav class="bg-gradient-to-r from-orange-600 to-red-600 text-white shadow-lg">
    <div class="container mx-auto px-4" x-data="{ open: false }">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center space-x-6">
                <h1 class="text-2xl font-bold">Admin Panel</h1>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-4">

                    <a href="{{ route('admin.dashboard') }}"
                        class="hover:bg-orange-700 px-4 py-2 rounded transition {{ request()->routeIs('admin.dashboard') ? 'bg-orange-700' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.candidates') }}"
                        class="hover:bg-orange-700 px-4 py-2 rounded transition {{ request()->routeIs('admin.candidates*') ? 'bg-orange-700' : '' }}">
                        Kelola Kandidat
                    </a>

                    <!-- Tombol Kelola Komentar -->
                    <a href="{{ route('admin.comments.index') }}"
                        class="hover:bg-orange-700 px-4 py-2 rounded transition">
                        💬 Kelola Komentar
                    </a>

                </div>
            </div>

            <div class="flex items-center space-x-4">
                <span class="hidden md:block">{{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-700 hover:bg-red-800 px-4 py-2 rounded transition">
                        Logout
                    </button>
                </form>

                <!-- Hamburger Button for Mobile -->
                <button class="md:hidden ml-2" @click="open = !open">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" class="md:hidden flex flex-col space-y-2 pb-4">
            <a href="{{ route('admin.dashboard') }}"
                class="hover:bg-orange-700 px-4 py-2 rounded transition {{ request()->routeIs('admin.dashboard') ? 'bg-orange-700' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.candidates') }}"
                class="hover:bg-orange-700 px-4 py-2 rounded transition {{ request()->routeIs('admin.candidates*') ? 'bg-orange-700' : '' }}">
                Kelola Kandidat
            </a>
             <!-- Tombol Kelola Komentar -->
                    <a href="{{ route('admin.comments.index') }}"
                        class="hover:bg-orange-700 px-4 py-2 rounded transition">
                        💬 Kelola Komentar
                    </a>

        </div>
    </div>
</nav>



<!-- Tambahkan Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>
