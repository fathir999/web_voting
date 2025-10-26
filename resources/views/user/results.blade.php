<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Voting - User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    @include('layouts.user-nav')

    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Hasil Voting Real-time</h1>
            <p class="text-gray-600">Total Voting: <strong>{{ $totalVotes }}</strong> suara</p>
        </div>

        <!-- Chart -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold mb-4">Grafik Perolehan Suara</h2>
            <div class="max-w-3xl mx-auto">
                <canvas id="resultsChart"></canvas>
            </div>
        </div>

        <!-- Results Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($candidates as $index => $candidate)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden {{ $index === 0 ? 'ring-4 ring-yellow-400' : '' }}">
                @if($index === 0)
                <div class="bg-yellow-400 text-center py-2">
                    <span class="text-yellow-900 font-bold">🏆 Peringkat 1</span>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        @if($candidate->photo)
                            <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->name }}" class="w-16 h-16 rounded-full object-cover mr-4">
                        @else
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                                {{ substr($candidate->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $candidate->name }}</h3>
                            <p class="text-sm text-gray-500">Peringkat #{{ $index + 1 }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Perolehan Suara</span>
                            <span class="font-bold text-blue-600">{{ $candidate->vote_percentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-4 rounded-full transition-all duration-500" style="width: {{ $candidate->vote_percentage }}%"></div>
                        </div>
                    </div>

                    <div class="text-center">
                        <span class="inline-block bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-bold text-xl">
                            {{ $candidate->vote_count }} Suara
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($candidates->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <p class="text-gray-500 text-lg">Belum ada hasil voting.</p>
        </div>
        @endif
    </div>

    <script>
        const ctx = document.getElementById('resultsChart').getContext('2d');
        const resultsChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($candidates->pluck('name')) !!},
                datasets: [{
                    label: 'Jumlah Suara',
                    data: {!! json_encode($candidates->pluck('vote_count')) !!},
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(251, 146, 60, 0.8)',
                        'rgba(236, 72, 153, 0.8)'
                    ],
                    borderColor: [
                        'rgb(59, 130, 246)',
                        'rgb(168, 85, 247)',
                        'rgb(34, 197, 94)',
                        'rgb(251, 146, 60)',
                        'rgb(236, 72, 153)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed + ' suara';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>