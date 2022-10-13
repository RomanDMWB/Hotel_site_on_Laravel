<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <link rel="icon" href="{{ url('images/site-icon.ico') }}">
    <link rel="stylesheet" type="text/less" href="{{ url('less/booking.less') }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <div class="ticket-container">
        <h1>Booking №{{ $id }}</h1>
        <div class="content">
            <p class="name">Arrival Date</p>
            <p class="content">{{ $booking['date'] }}</p>
            <p class="name">Night Count</p>
            <p class="content">{{ $booking['nights'] }}</p>
            <p class="name">Adult Count</p>
            <p class="content">{{ $booking['adults'] }}</p>
            <p class="name">Children Count</p>
            <p class="content">{{ $booking['childs'] }}</p>
            <p class="name">Room Type</p>
            <p class="content">{{ $type }}</p>
            <p class="name">Place Number</p>
            <p class="content">{{ $place }}</p>
            <p class="name">Total</p>
            <p class="content">{{ $booking['cost'] }}</p>
        </div>
        <a href="javascript:history.go(-1)">Back</a>
    </div>
    <script src="{{ url('js/less.js') }}"></script>
</body>
</html>
