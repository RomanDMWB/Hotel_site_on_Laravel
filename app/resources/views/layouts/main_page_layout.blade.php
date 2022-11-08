<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    @switch(explode('/',$_SERVER['REQUEST_URI'])[1])
    @case('room')
    <link rel="stylesheet" type="text/less" href="{{ url('less/room.less') }}">
    @break
    @case('about')
    <link rel="stylesheet" type="text/less" href="{{ url('less/all/about.less') }}">
    @break
    @case('user')
    <link rel="stylesheet" type="text/less" href="{{ url('less/all/user-page.less') }}">
    @break
    @case('contacts')
    <link rel="stylesheet" type="text/less" href="{{ url('less/all/contacts.less') }}">
    @break
    $@default
    @if($_SERVER['REQUEST_URI']==='/'||$_SERVER['REQUEST_URI']==='/welcome/error')
    <link rel="stylesheet" type="text/less" href="{{ url('less/welcome.less') }}">
    @endif
    @break
    @endswitch
    @if($errors->any()||isset($error))
    <link rel="stylesheet" type="text/less" href="{{ url('less/error.less') }}">
    @endif
    <link rel="stylesheet" type="text/less" href="{{ url('less/main.less') }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="icon" href="{{ url('images/site-icon.ico') }}">
</head>
<body>
    @include('navbar')
    <div class="error">
        @include('layouts.error_layout')
    </div>
    <div class="content">
        @yield('content')
    </div>
    @include('footer')
    <script src="{{ url('js/less.js') }}"></script>
</body>
</html>
