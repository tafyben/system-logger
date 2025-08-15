<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <x-slot name="header">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                History for: {{ $log->title }}
            </h2>
        </x-slot>

        <table class="min-w-full border border-gray-300 bg-white shadow-sm rounded">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">User</th>
                <th class="px-4 py-2 text-left">Event</th>
                <th class="px-4 py-2 text-left">Changes</th>
                <th class="px-4 py-2 text-left">Time</th>
            </tr>
            </thead>
            <tbody>
            @foreach($activities as $activity)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $activity->causer->name ?? 'System' }}</td>
                    <td class="px-4 py-2">{{ $activity->description }}</td>
                    <td class="px-4 py-2">
                        <pre class="text-xs">{{ json_encode($activity->properties->toArray(), JSON_PRETTY_PRINT) }}</pre>
                    </td>
                    <td class="px-4 py-2">{{ $activity->created_at->format('D d M Y H:i:s') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="{{ route('logs.index') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Back to Logs
        </a>
    </div>
</x-app-layout>
