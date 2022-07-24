@extends('layouts.main_page_layout')

@section('content')
<form action="{{ url('admin/room/update/service/'.$id) }}" method="post">
    @csrf
    @method('put')
    <div class="form-group">
        <label>Service for '{{ $room['name'] }}' room</label>
        <select name="serviceId">
            @forelse($services as $key=>$item)
            <option value="{{ $key }}">{{ $item['name'] }}</option>
            @empty
            <option value="">Not Found</option>
            @endforelse
        </select>
    </div>
    <button type="submit">Add</button>
</form>
@endsection