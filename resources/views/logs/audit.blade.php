<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Audit Trail') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-semibold mb-4">System Audit Logs</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Log ID
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Event
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Performed By
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Changes
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Date
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($histories as $activity)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $activity->id }}
                                    </td>
                                    <td class="px-4 py-2 text-sm capitalize text-gray-700 dark:text-gray-300">
                                        {{ $activity->event }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $activity->description }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $activity->causer?->name ?? 'System' }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                                        <details>
                                            <summary class="cursor-pointer text-blue-500">View Changes</summary>
                                            <div class="mt-2">
                                                <strong>Old:</strong>
                                                <pre class="bg-gray-100 dark:bg-gray-900 p-2 rounded text-xs">
{{ json_encode($activity->properties['old'] ?? [], JSON_PRETTY_PRINT) }}
                                                    </pre>
                                                <strong>New:</strong>
                                                <pre class="bg-gray-100 dark:bg-gray-900 p-2 rounded text-xs">
{{ json_encode($activity->properties['attributes'] ?? [], JSON_PRETTY_PRINT) }}
                                                    </pre>
                                            </div>
                                        </details>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $activity->created_at->format('Y-m-d H:i:s') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No audit logs found.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $histories->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
