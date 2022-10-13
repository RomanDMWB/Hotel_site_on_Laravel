@extends('layouts.main_page_layout')

@section('content')
{{-- {{ $bookings }} --}}
@if(isset($bookings)&&$bookings!=="")
<div class="bookings">
    <h1>Your's booking for hotel numbers</h1>
    @foreach($bookings as $key => $booking)
    <div>
        <p class='header'>Booking №{{ $key }}</p>
        <div class="info">
            <p class="name">Arrival Date</p>
            <p class="content">{{ $booking['date'] }}</p>
            <p class="name">Night Count</p>
            <p class="content">{{ $booking['nights'] }}</p>
            <p class="name">Adult Count</p>
            <p class="content">{{ $booking['adults'] }}</p>
            <p class="name">Children Count</p>
            <p class="content">{{ $booking['childs'] }}</p>
            <p class="name">Room Type</p>
            <p class="content">{{ $booking['type'] }}</p>
            <p class="name">Place Number</p>
            <p class="content">{{ $booking['place'] }}</p>
            <p class="name">Total</p>
            <p class="content">{{ $booking['cost'] }}</p>
        </div>
        <a href="{{ url('booking/'.$key) }}">Info</a>
    </div>
    @endforeach
</div>
@else
<h1>Простите, но у вас пока нет заказов</h1>
@endif
@endsection
