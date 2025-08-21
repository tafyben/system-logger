<x-app-layout>
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Edit Log</h1>

        <form method="POST" action="{{ route('logs.update', $log->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Log Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Log Type</label>
                <select name="log_type_id"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" @selected($type->id == $log->log_type_id)>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $log->title) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description"
                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                          rows="3">{{ old('description', $log->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                    Notes (Optional)
                </label>
                <textarea
                    name="notes"
                    id="notes"
                    rows="4"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >{{ old('notes', $log->notes ?? '') }}</textarea>
            </div>


            <!-- Affected System -->
            <div class="mb-4">
                <label for="system_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Affected System
                </label>
                <select id="system_id" name="system_id"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach($systems as $system)
                        <option value="{{ $system->id }}"
                            {{ $log->system_id == $system->id ? 'selected' : '' }}>
                            {{ $system->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <!-- Department -->
            <div>
                <label for="department_id">Department</label>
                <select id="department_id" name="department_id"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}"
                            {{ old('department_id', $log->department_id ?? '') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }} ({{ $department->location->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Event Time -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Event Time</label>
                <input type="datetime-local" name="event_time"
                       value="{{ old('event_time', \Carbon\Carbon::parse($log->event_time)->format('Y-m-d\TH:i')) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>

            <!-- Submit -->
            <div class="flex justify-end">
                <a href="{{ route('logs.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</a>
                <button type="submit" class="ml-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
            </div>
        </form>

            <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">

            <script>
                new TomSelect("#system_id",{
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
            </script>
</x-app-layout>
