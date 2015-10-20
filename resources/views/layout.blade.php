<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel project</title>

    <link rel="stylesheet" href="/libs/bootstrap/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/libs/bootstrap-material/dist/css/material.min.css"/>
    <link rel="stylesheet" href="/css/style.css"/>
</head>
<body>

    @yield('content')

<script src="{!! asset('/libs/jquery/dist/jquery.min.js') !!}"></script>
<script src="{!! asset('/libs/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('/libs/bootstrap-material/dist/js/material.min.js') !!}"></script>
<script src="{!! asset('/js/common.js') !!}"></script>
</body>
</html>