<?php header("Content-Type: text/html; charset=utf-8"); ?>

@extends('layouts.admin_page_layout')

@section('content')
<form action="{{ url('admin/booking/update/'.$id) }}" method="post">
    @csrf
    @foreach($booking as $item=>$key)
        <div class="form-group">
            <label>{{ $item }}:</label>
            <input type="text" name="{{ $item }}" class="form-control" required value="{{ $key }}">
        </div>
    @endforeach
    <div class="form-group">
        <button type="submit" class="btn">Обновить</button>
    </div>
</form>
@endsection