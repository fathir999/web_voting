<nav class="bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg">
    <div class="container mx-auto px-4" x-data="{ open: false }">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center space-x-6">
                <h1 class="text-2xl font-bold">E-Voting System</h1>
                <!-- Desktop menu -->
                <div class="hidden md:flex space-x-4">
                    <a href="{{ route('user.vote') }}" class="hover:bg-blue-700 px-4 py-2 rounded transition {{ request()->routeIs('user.vote') ? 'bg-blue-700' : '' }}">
                        Voting
                    </a>
                    <a href="{{ route('user.results') }}" class="hover:bg-blue-700 px-4 py-2 rounded transition {{ request()->routeIs('user.results') ? 'bg-blue-700' : '' }}">
                        Hasil
                    </a>
                </div>
            </div>

            <!-- User info + logout -->
            <div class="flex items-center space-x-4">
                <span class="hidden md:block">{{ Auth::user()->name }}</span>
                @if(Auth::user()->has_voted)
                    <span class="bg-green-500 px-3 py-1 rounded-full text-xs font-semibold">✓ Sudah Vote</span>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-purple-700 hover:bg-purple-800 px-4 py-2 rounded transition">
                        Logout
                    </button>
                </form>

                <!-- Hamburger button -->
                <button class="md:hidden ml-2" @click="open = !open">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="open" class="md:hidden flex flex-col space-y-2 pb-4">
            <a href="{{ route('user.vote') }}" class="hover:bg-blue-700 px-4 py-2 rounded transition {{ request()->routeIs('user.vote') ? 'bg-blue-700' : '' }}">
                Voting
            </a>
            <a href="{{ route('user.results') }}" class="hover:bg-blue-700 px-4 py-2 rounded transition {{ request()->routeIs('user.results') ? 'bg-blue-700' : '' }}">
                Hasil
            </a>
        </div>
    </div>
</nav>

<!-- Tambahkan Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>
