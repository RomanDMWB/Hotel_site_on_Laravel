<?php header("Content-Type: text/html; charset=utf-8"); ?>

@extends('layouts.admin_page_layout')

@section('content')
@if(!isset($contact))
<form action="{{ url('admin/contact/add') }}" method="post">
    @csrf
    <div class="form-group">
        <label>Contact Header</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Contact Content</label>
        <input type="text" name="content" class="form-control" required>
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
<form action="{{ url('admin/contact/update/'.$id) }}" method="post">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label>Contact Header</label>
        <input type="text" name="name" class="form-control" required value="{{ $contact['name'] }}">
    </div>
    <div class="form-group">
        <label>Contact Content</label>
        <input type="text" name="content" class="form-control" required value='{{ $contact["content"] }}'>
    </div>
    <div class="form-group">
        <label>Icon</label>
        <input type="text" name="icon" class="form-control" required value='{{ $contact["icon"] }}'>
    </div>
    <div class="form-group">
        <button type="submit" class="btn">Обновить</button>
    </div>
</form>
@endif
@endsection