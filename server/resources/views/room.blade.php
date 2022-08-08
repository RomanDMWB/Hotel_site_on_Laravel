@extends('layouts.main_page_layout')

@section('content')
<div class="room-picture" style="background-image:url({{ url($room['image']) }})">
    <div class="room-info">
        <p class="header">Room Info</p>
        <div class="info">
            <p class="header">Size</p>
            <p class="content">{{ $room['size'] }}</p>
            <p class="header">Cost</p>
            <p class="content">{{ $room['cost'] }}</p>
        </div>
        <a href="" class="btn">BOOKING NOW</a>
    </div> 
</div>
@endsection