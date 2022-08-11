@extends('layouts.main_page_layout')

@section('content')
<div class="room-picture" style="background-image:url({{ url($room['image']) }})">
    <div class="room-info">
        <div class="header">
            <p>Room </p>
            <p class="gold-text">Info</p>
        </div>
        <div class="info">
            <p class="name">Size:</p>
            <p class="content">{{ $room['size'] }} m&#178;</p>
            <p class="name">Cost:</p>
            <p class="content">{{ $room['cost'] }} ₽</p>
        </div>
        <a href="" class="btn">BOOKING NOW</a>
    </div> 
</div>
<div class="room-full-information">
    <p class="header">{{ $room['name'] }}</p>
    <div class="description">
        <span class="description-text">{{ $room['description'] }}</span>
    </div>
    <div class="service-info">
        <p class="header">Rooms Services</p>
        <span class="description">Praeterea iter est quasdam resdican tur magna mollis euismodminim veni Contra legem facit qui id facit.</span>
        @if($room['services'])
        <ul class="services">
            @foreach($room['services'] as $item)
                <li>
                    <i>{!! $item['icon'] !!}</i>
                    <p>{{ $item['name'] }}</p>
                </li>
            @endforeach
        </ul>
        @else
        <p class="not-found">Not Found</p>
        @endif
    </div>
</div>
@endsection