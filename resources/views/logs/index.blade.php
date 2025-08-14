<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <x-slot name="header">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Logs - All') }}
            </h2>
        </x-slot>

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('logs.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                + Add Log
            </a>
        </div>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Time - Logged</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">System</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($logs as $log)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $log->event_time }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $log->type->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $log->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $log->affected_system }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $log->user->name }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('logs.history', $log->id) }}"
                               class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 text-sm">
                                View History
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>

</x-app-layout>
