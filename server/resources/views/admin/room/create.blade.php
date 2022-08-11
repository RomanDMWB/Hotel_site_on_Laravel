@extends('layouts.admin_page_layout')

@section('content')
<form action="<?php if(isset($room)) echo url('admin/room/update/'.$id); else echo url('admin/room/add') ?>" method="post">
    @csrf
    <div class="form-group">
        <label>Room Name</label>
        <input type="text" name="name" class="form-control" value="<?php if(isset($room)) echo $room['name']?>" required>
    </div>
    <div class="form-group">
        <label>Cost</label>
        <input type="number" name="cost" class="form-control" value="<?php if(isset($room)) echo $room['cost']?>" required>
    </div>
    <div class="form-group">
        <label>Size</label>
        <input type="text" name="size" class="form-control" value="<?php if(isset($room)) echo $room['size']?>" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea type="text" name="description" class="form-control" required><?php if(isset($room)) echo $room['description']?></textarea>
    </div>
    <div class="form-group">
        <label>Image Patch</label>
        <textarea type="text" name="image" class="form-control" required><?php if(isset($room)) echo $room['image']?></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn"><?php if(isset($room)) echo 'Обновить'; else echo 'Добавить' ?></button>
    </div>
</form>
@endsection