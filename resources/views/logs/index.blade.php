<x-app-layout>
    <div class="container">
        <h1>Logs</h1>
        <a href="{{ route('logs.create') }}" class="btn btn-primary mb-3">Add Log</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Time</th>
                <th>Type</th>
                <th>Title</th>
                <th>System</th>
                <th>User</th>
            </tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->event_time }}</td>
                    <td>{{ $log->type->name }}</td>
                    <td>{{ $log->title }}</td>
                    <td>{{ $log->affected_system }}</td>
                    <td>{{ $log->user->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $logs->links() }}
    </div>
</x-app-layout>
