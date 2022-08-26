<?php header("Content-Type: text/html; charset=utf-8"); ?>

@extends('layouts.admin_page_layout')

@section('content')
@if(!isset($service))
<form action="{{ url('admin/service/add') }}" method="post">
    @csrf
    <div class="form-group">
        <label>Service Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Icon</label>
        <input type="text" name="icon" class="form-control" required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn">Добавить</button>
    </div>
</form>
@else
<form action="{{ url('admin/service/update/'.$id) }}" method="post">
    @csrf
    @method('put')
    <div class="form-group">
        <label>Service Name</label>
        <input type="text" name="name" class="form-control" required value="{{ $service['name'] }}">
    </div>
    <div class="form-group">
        <label>Icon</label>
        <input type="text" name="icon" class="form-control" required value="{{ $service['icon'] }}">
    </div>
    <div class="form-group">
        <button type="submit" class="btn">Обновить</button>
    </div>
</form>

@endif
@endsection