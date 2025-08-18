<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Trash - Deleted Logs') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Back Button -->
                <div class="flex justify-end mb-4">
                    <a href="{{ route('logs.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Back to Logs
                    </a>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 rounded-lg">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Title</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Log Type</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Affected System</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Deleted At</th>
                            <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($logs as $log)
                            <tr>
                                <td class="px-4 py-2">{{ $log->title }}</td>
                                <td class="px-4 py-2">{{ $log->log_type }}</td>
                                <td class="px-4 py-2">{{ $log->affected_system }}</td>
                                <td class="px-4 py-2">{{ $log->deleted_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-2 text-center">
                                    <div class="inline-flex space-x-2">

                                        <!-- Restore Button -->
                                        <form action="{{ route('logs.restore', $log->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="flex items-center px-3 py-1 bg-green-600 dark:bg-green-600 hover:bg-green-700 text-white font-semibold text-sm rounded shadow">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M4 4v6h6M20 20v-6h-6M4 10l10 10M20 14L10 4"/>
                                                </svg>
                                                Restore
                                            </button>
                                        </form>

                                        <!-- Permanent Delete Button -->
                                        <form action="{{ route('logs.forceDelete', $log->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to permanently delete this log?')"
                                                    class="flex items-center px-3 py-1 bg-red-600 dark:bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded shadow">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                                    No deleted logs found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $logs->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
