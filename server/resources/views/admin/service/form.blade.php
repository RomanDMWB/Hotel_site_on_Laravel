<?php header("Content-Type: text/html; charset=utf-8"); ?>

@extends('layouts.admin_page_layout')

@section('content')
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
@endsection