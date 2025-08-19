<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold">Total Logs</h3>
                    <p class="text-2xl text-indigo-600">{{ $stats['total_logs'] }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold">Deleted Logs</h3>
                    <p class="text-2xl text-red-600">{{ $stats['deleted_logs'] }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold">Users</h3>
                    <p class="text-2xl text-green-600">{{ $stats['users'] }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold">Systems</h3>
                    <p class="text-2xl text-purple-600">{{ $stats['systems'] }}</p>
                </div>
            </div>

            {{-- Recent Logs --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Recent Logs</h3>
                <ul class="divide-y divide-gray-200">
                    @foreach ($recentLogs as $log)
                        <li class="py-3 flex justify-between">
                            <div>
                                <p class="font-semibold">{{ $log['title'] }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $log['type'] }} • by {{ $log['user'] }}
                                </p>
                            </div>
                            <span class="text-sm text-gray-400">{{ $log['time'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Logs by Type</h3>
                    <canvas id="logsByTypeChart"></canvas>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Logs per Day (Last 7 Days)</h3>
                    <canvas id="logsPerDayChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Logs by Type
        const ctx1 = document.getElementById('logsByTypeChart').getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    data: @json($chartData['data']),
                    backgroundColor: ['#4F46E5', '#EF4444', '#10B981', '#F59E0B'],
                }]
            }
        });

        // Logs per Day
        const ctx2 = document.getElementById('logsPerDayChart').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: @json($chartLogsPerDay['labels']),
                datasets: [{
                    label: 'Logs',
                    data: @json($chartLogsPerDay['data']),
                    borderColor: '#2563EB',
                    backgroundColor: '#93C5FD',
                    fill: true,
                    tension: 0.4
                }]
            }
        });
    </script>
</x-app-layout>
