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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Recent Change</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($logs as $log)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition align-middle">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $log->event_time }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $log->type->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $log->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $log->affected_system }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $log->user->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            @if($log->activities->count())
                                @php
                                    $latest = $log->activities->first();
                                @endphp
                                <span title="{{ json_encode($latest->properties->toArray()) }}">
                            {{ $latest->description }}
                        </span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2 align-middle flex items-center justify-center space-x-2">
                            <!-- View History Button -->
                            <a href="{{ route('logs.history', $log->id) }}" title="View History"
                               class="bg-gray-200 hover:bg-gray-300 p-1 rounded text-gray-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>

                            <!-- Edit Button -->
                            <a href="{{ route('logs.edit', $log->id) }}" title="Edit"
                               class="bg-blue-200 hover:bg-blue-300 p-1 rounded text-blue-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('logs.destroy', $log->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this log?')"
                                        class="bg-red-200 hover:bg-red-300 p-1 rounded text-red-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
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
