<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting - User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    @include('layouts.user-nav')

    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Sistem E-Voting</h1>
            <p class="text-gray-600">Pilih kandidat pilihan Anda</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if ($hasVoted)
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-6 py-4 rounded-lg mb-6">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="font-bold">Anda sudah melakukan voting!</p>
                        <p class="text-sm">Pilihan Anda: <strong>{{ $userVote->candidate->name }}</strong></p>
                        <p class="text-xs mt-1">Waktu: {{ $userVote->voted_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        @endif

        
       <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach ($candidates as $candidate)
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-[1.02] hover:shadow-2xl">
            
            <!-- Foto kandidat -->
            <div class="h-[45vh] sm:h-[40vh] bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                @if ($candidate->photo)
                    <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->name }}"
                        class="w-full h-full object-cover object-top">
                @else
                    <div class="text-white text-7xl font-bold">{{ substr($candidate->name, 0, 1) }}</div>
                @endif
            </div>

            <!-- Detail kandidat -->
            <div class="flex flex-col justify-between p-6 space-y-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 text-center mb-3">{{ $candidate->name }}</h3>

                    @if ($candidate->vision)
                        <div class="mb-3">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Visi</p>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ Str::limit($candidate->vision, 120) }}</p>
                        </div>
                    @endif

                    @if ($candidate->mission)
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Misi</p>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ Str::limit($candidate->mission, 120) }}</p>
                        </div>
                    @endif
                </div>

                <!-- Komentar -->
                @if (!$hasVoted)
                    <form action="{{ route('user.comments.store') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                        <textarea name="message" placeholder="Tulis komentar..."
                            class="border border-gray-300 rounded-lg w-full p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none resize-none"
                            rows="2"></textarea>
                        <button type="submit"
                            class="w-full bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-2 rounded-lg mt-2 transition duration-200">
                            💬 Kirim Komentar
                        </button>
                    </form>
                @endif

                <!-- Tombol vote -->
                <div class="pt-2">
                    @if (!$hasVoted)
                        <form method="POST" action="{{ route('user.vote.store') }}"
                            onsubmit="return confirm('Yakin memilih {{ $candidate->name }}? Pilihan tidak dapat diubah!')">
                            @csrf
                            <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-3 rounded-lg transition duration-300 shadow">
                                🗳️ Vote untuk {{ $candidate->name }}
                            </button>
                        </form>
                    @else
                        <button disabled
                            class="w-full bg-gray-200 text-gray-500 font-semibold py-3 rounded-lg cursor-not-allowed">
                            Voting Ditutup
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>



        @if ($candidates->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <p class="text-gray-500 text-lg">Belum ada kandidat tersedia untuk voting.</p>
            </div>
        @endif
    </div>
</body>

</html>
