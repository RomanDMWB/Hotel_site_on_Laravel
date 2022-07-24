@extends('layouts.main_page_layout')

@section('content')
<form action="{{ url('admin/room/add') }}" method="post">
    @csrf
    <div class="form-group">
        <label>Room Name</label>
        <input type="text" name="name" class="form-control">
    </div>
    <div class="form-group">
        <label>Cost</label>
        <input type="number" name="cost" class="form-control">
    </div>
    <div class="form-group">
        <label>Size</label>
        <input type="text" name="size" class="form-control">
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea type="text" name="description" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label>Image Patch</label>
        <textarea type="text" name="image" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn">Добавить</button>
    </div>
</form>
@endsection