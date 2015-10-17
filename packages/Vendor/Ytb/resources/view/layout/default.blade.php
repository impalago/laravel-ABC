<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Youtube</title>

    <link rel="stylesheet" href="/libs/bootstrap/dist/css/bootstrap.min.css"/>
</head>
<body>

    <div class="container">
        @yield('content')
    </div>

<script src="{!! asset('/libs/jquery/dist/jquery.min.js') !!}"></script>
<script src="{!! asset('/libs/bootstrap/dist/bootstrap.min.js') !!}"></script>
@yield('scripts')
</body>
</html>