@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Log</h1>
        <form method="POST" action="{{ route('logs.store') }}">
            @csrf
            <div class="mb-3">
                <label>Log Type</label>
                <select name="log_type_id" class="form-control">
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Title</label>
                <input name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>Affected System</label>
                <input name="affected_system" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Event Time</label>
                <input type="datetime-local" name="event_time" class="form-control" required>
            </div>

            <button class="btn btn-success">Save</button>
        </form>
    </div>
@endsection
