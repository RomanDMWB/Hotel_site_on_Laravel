<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link rel="stylesheet" type="text/less" href="{{ url('less/navbar.less') }}">
    <link rel="stylesheet" type="text/less" href="{{ url('less/main.less') }}">
    <link rel="stylesheet" type="text/less" href="{{ url('less/admin.less') }}">
    <link rel="icon" href="{{ url('images/site-icon.ico') }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    @include('navbar')
    <div class="content">
            @yield('content')
    </div>
    <script src="{{ url('js/less.js') }}"></script>
    <script>
        if(document.getElementById('destroy-button'))
            document.getElementById('destroy-button').addEventListener('click',(e)=>{
                if(!confirm('Are you sure to delete the data?'))
                    e.preventDefault();
            })
    </script>
</body>
</html>