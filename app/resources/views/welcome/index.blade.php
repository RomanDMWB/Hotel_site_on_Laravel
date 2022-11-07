@extends('layouts.main_page_layout')

@section('content')
<!-- Room categories content -->
<div class="hotel-variants">
    <ul class="rooms">
        @if($rooms)
        @foreach($rooms as $key => $item)
        <li class="hotel-room" style="background-image:url('{{ url($item['image']) }}')">
            <div class="room-info">
                <div class="room-header">
                    <p class='room-header-text'>{{ $item['name'] }}</p>
                </div>
                <div class="room-content">
                    <div class="services">
                        <h4>Services:</h4>
                        @if($item['services'])
                        <ul class="service-collection">
                            @foreach($item['services'] as $service)
                            <li class="service-item">
                                <p class="icon">{!! $service['icon'] !!}</p>
                                <p class="service-name">{{ $service['name'] }}</p>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p>Services Not Found</p>
                        @endif
                    </div>
                    <p>Cost:{{ $item['cost'] }}</p>
                    <a href="{{ url('room/'.$key) }}" class="btn">Watch</a>
                </div>
            </div>
        </li>
        @endforeach
        @else
        <h4>Sorry, rooms not found</h4>
        @endif
    </ul>
</div>
<!-- Correct visible rooms -->
<script>
    document.querySelector('.rooms').style.gridTemplateColumns = `repeat(${document.querySelectorAll('.hotel-room').length},1fr)`

</script>
<!-- Select panel & Search form content -->
<div class="about-booking-form-container">
    <div class="select-panel">
        <div class="select-buttons">
            <div class="select-group about">
                <i class="big icon hotel-icon"></i>
                <a class="select-button">About Hotel</a>
            </div>
            <div class="select-group booking">
                <i class="big icon booking-icon"></i>
                <a class="select-button">Booking room</a>
            </div>
        </div>
    </div>
    <!-- Container About Copmany Info -->
    <div class="container about-container">
        <div class="paragraph">
            <div class="golden-text">WELCOME TO</div>
            <div class="bold-big-text">LUXERY BEST HOTEL</div>
        </div>
        <div class="description">Duis at ante nec neque rhoncus pretium. Utpl mollis, est non scelerisque blandit, velit nunc lao in vehicula sem phasellu efore. Proin gravida nibh vel velit auctor aliquet.</div>
        <div class="company-info">
            <div class="number-in-world">
                <div class="label">World Best Resort No</div>
                <div class="number">06</div>
            </div>
            <div class="awarded-year">
                <div class="label">We Are Awarded In</div>
                <div class="number">2014</div>
            </div>
            <div class="brunches-number">
                <div class="label">Number of rooms</div>
                <div class="number">100</div>
            </div>
        </div>
    </div>
    <!-- Container of Booking Room Form -->
    <div class="container booking-container">
        <div class="heading">
            Booking your perfect room
        </div>
        <form action="{{ url('booking') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="">Arrival Date</label>
                <input type="date" name='date' required min="<?php echo date ('Y-m-d'); ?>">
            </div>
            <div class="form-group">
                <label for="">Night Count</label>
                <input type="number" max='30' min='0' required name='nights' value="0">
            </div>
            <div class="form-group">
                <label for="">Adults</label>
                <input type="number" max='5' min='0' required name='adults' value="0">
            </div>
            <div class="form-group">
                <label for="">Kids</label>
                <input type="number" max='5' min='0' required name='childs' value="0">
            </div>
            <div class="form-group">
                <label for="">Room Type</label>
                <select name="type" required>
                    @if($rooms)
                    @foreach($rooms as $key=>$item)
                    <option value="{{ $key }}">{{ $item['name'] }}</option>
                    @endforeach
                    @else
                    <option value="">Not Found</option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="BOOKING NOW">
            </div>
        </form>
    </div>
</div>
<!-- Processing select button click -->
<script>
    const aboutContainerElement = document.querySelector('.about-container');
    const searchContainerElement = document.querySelector('.booking-container');
    const containerDisplayName = 'block';
    searchContainerElement.style.display = 'none';
    document.querySelector('.about').classList.add('active');
    document.querySelectorAll('.select-group').forEach(button => {
        button.addEventListener('click', () => {
            if (button.classList.contains('active')) return;
            // Disappear all containers
            aboutContainerElement.style.display = 'none';
            searchContainerElement.style.display = 'none';
            // Delete active format all control panel buttons
            document.querySelectorAll('.select-group').forEach(button => {
                button.classList.remove('active');
            });
            // Appear correct containers and show color in button
            button.classList.add('active');
            if (button.classList.contains('about'))
                aboutContainerElement.style.display = containerDisplayName;
            if (button.classList.contains('booking'))
                searchContainerElement.style.display = containerDisplayName;
        })
    })

</script>
@endsection
