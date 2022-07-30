<?php header("Content-Type: text/html; charset=utf-8"); ?>

@extends('layouts.admin_page_layout')

@section('content')
<form action="{{ url('admin/place/add') }}" method="post">
    @csrf
    <div class="form-group">
        <label>Place Number</label>
        <input type="text" required name="place_number" class="form-control">
    </div>
    <div class="form-group">
        <label>Room Type</label>
        <select name="room_type" required class="form-control">
            @if($rooms)
            @foreach($rooms as $key=>$room)
                <option value="{{ $key }}">{{ $room['name'] }}</option>
            @endforeach
            @else
            <option value="">Not Found</option>
            @endif
        </select>
    </div>
    <div class="form-group">
        <label>Is Occupied</label>
        <input type="checkbox" name="occupied" class="form-control">
    </div>
    @if($rooms)
    <div class="form-group">
        <button type="submit" class="btn">Добавить</button>
    </div>
    @endif
</form>
@endsection