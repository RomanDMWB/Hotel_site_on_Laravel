<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <link rel="stylesheet" type="text/less" href="{{ url('less/navbar.less') }}">
    <link rel="stylesheet" type="text/less" href="{{ url('less/welcome.less') }}">
    <link rel="stylesheet" type="text/less" href="{{ url('less/main.less') }}">
    <link rel="stylesheet" type="text/less" href="{{ url('less/footer.less') }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="icon" href="{{ url('images/site-icon.ico') }}">
</head>
<body>
    @include('navbar')
    <div class="content">
            @yield('content')
        <footer></footer>
    </div>
    @include('footer');
    <script src="{{ url('js/less.js') }}"></script>
</body>
</html>