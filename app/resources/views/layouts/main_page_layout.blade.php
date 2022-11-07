<?php 
$isContactPage = explode('/',$_SERVER['REQUEST_URI'])[1]==='contacts';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    @if($_SERVER['REQUEST_URI']==='/'||$_SERVER['REQUEST_URI']==='/welcome/error')
    <link rel="stylesheet" type="text/less" href="{{ url('less/welcome.less') }}">
    @endif
    @if(explode('/',$_SERVER['REQUEST_URI'])[1]==='room')
    <link rel="stylesheet" type="text/less" href="{{ url('less/room.less') }}">
    @endif
    @if(explode('/',$_SERVER['REQUEST_URI'])[1]==='about')
    <link rel="stylesheet" type="text/less" href="{{ url('less/all/about.less') }}">
    @endif
    @if(explode('/',$_SERVER['REQUEST_URI'])[1]==='user')
    <link rel="stylesheet" type="text/less" href="{{ url('less/all/user-page.less') }}">
    @endif
    @if($isContactPage)
    <link rel="stylesheet" type="text/less" href="{{ url('less/all/contacts.less') }}">
    @endif
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
