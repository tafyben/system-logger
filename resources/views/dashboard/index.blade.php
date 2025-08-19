<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats Overview --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">Total Logs</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_logs'] }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">Deleted Logs</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['deleted_logs'] }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">Users</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['users'] }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">Systems Tracked</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['systems'] }}</div>
                </div>
            </div>

            {{-- Recent Logs --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Recent Logs</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentLogs as $log)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $log['title'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $log['type'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $log['user'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-500">{{ $log['time'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

