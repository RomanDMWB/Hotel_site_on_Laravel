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
    <h1>Ticket for {{$name}}</h1>
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
            <input type="text" hidden value="{{ $type }}" name='type'>
        </div>
        <div class="form-group buttons">
            <input type="submit" value="BOOKING NOW" class="btn">
            <a href="javascript:history.go(-1)" class='btn'>Back</a>
        </div>
    </form>
    <script src="{{ url('js/less.js') }}"></script>
</body>
</html>
