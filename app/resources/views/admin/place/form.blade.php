<?php header("Content-Type: text/html; charset=utf-8"); ?>

@extends('layouts.admin_page_layout')

@section('content')
@if(!isset($place))
<form action="{{ url('admin/place/add') }}" method="post">
    @csrf
    <div class="form-group">
        <label>Place Number</label>
        <input type="number" required name="number" class="form-control">
    </div>
    <div class="form-group">
        <label>Room Type</label>
        <select name="type" required class="form-control">
            @if($rooms)
            @foreach($rooms as $key=>$room)
                <option value="{{ $key }}">{{ $room['name'] }}</option>
            @endforeach
            @else
            <option value="">Not Found</option>
            @endif
        </select>
    </div>
    @if($rooms)
    <div class="form-group">
        <button type="submit" class="btn">Добавить</button>
    </div>
    @endif
</form>
@else
<form action="{{ url('admin/place/update/'.$id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Place Number</label>
        <input type="number" required name="number" class="form-control" value="{{ $place['number'] }}">
    </div>
    <div class="form-group">
        <label>Room Type</label>
        <select name="type" required class="form-control">
            @if($rooms)
            @foreach($rooms as $key=>$room)
                <option <?php if($room['name']==$place['type']) echo 'selected' ?> value="{{ $key }}">{{ $room['name'] }}</option>
            @endforeach
            @else
            <option value="">Not Found</option>
            @endif
        </select>
    </div>
    @if($rooms)
    <div class="form-group">
        <button type="submit" class="btn">Обновить</button>
    </div>
    @endif
</form>

@endif
@endsection