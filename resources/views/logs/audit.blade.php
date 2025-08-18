<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('System Audit / Log History') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Filters -->
                <form method="GET" class="flex flex-wrap gap-2 mb-6 items-end">
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-700">Action</label>
                        <select name="action" class="px-2 py-1 border rounded">
                            <option value="">All Actions</option>
                            <option value="created" {{ request('action')=='created' ? 'selected' : '' }}>Created</option>
                            <option value="updated" {{ request('action')=='updated' ? 'selected' : '' }}>Updated</option>
                            <option value="deleted" {{ request('action')=='deleted' ? 'selected' : '' }}>Deleted</option>
                            <option value="restored" {{ request('action')=='restored' ? 'selected' : '' }}>Restored</option>
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm text-gray-700">User</label>
                        <select name="user_id" class="px-2 py-1 border rounded">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id')==$user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm text-gray-700">From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-2 py-1 border rounded">
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm text-gray-700">To</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-2 py-1 border rounded">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Filter
                        </button>
                    </div>
                </form>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 rounded-lg">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Log Title</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Action</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">User</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Before</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">After</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Timestamp</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($histories as $history)
                            @php
                                $action = strtolower($history->description);
                                $bgClass = match(true) {
                                    str_contains($action, 'created') => 'bg-green-100',
                                    str_contains($action, 'updated') => 'bg-yellow-100',
                                    str_contains($action, 'deleted') => 'bg-red-100',
                                    str_contains($action, 'restored') => 'bg-blue-100',
                                    default => 'bg-gray-100',
                                };
                            @endphp
                            <tr class="{{ $bgClass }}">
                                <td class="px-4 py-2">{{ $history->subject->title ?? 'Deleted Log' }}</td>
                                <td class="px-4 py-2 font-medium capitalize">{{ $history->description }}</td>
                                <td class="px-4 py-2">{{ $history->causer->name ?? 'Unknown' }}</td>
                                <td class="px-4 py-2">
                                    @if(!empty($history->properties['old']))
                                        <pre class="whitespace-pre-wrap">{{ json_encode($history->properties['old'], JSON_PRETTY_PRINT) }}</pre>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @if(!empty($history->properties['attributes']))
                                        <pre class="whitespace-pre-wrap">{{ json_encode($history->properties['attributes'], JSON_PRETTY_PRINT) }}</pre>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $history->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 text-center text-gray-500">No history found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $histories->withQueryString()->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
