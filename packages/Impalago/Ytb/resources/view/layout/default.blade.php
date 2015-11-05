<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Youtube</title>

    <link rel="stylesheet" href="/libs/bootstrap/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/libs/bootstrap-material/dist/css/material.min.css"/>
    <link rel="stylesheet" href="/css/ytb.css"/>
</head>
<body>

    <div class="container">
        @yield('content')
    </div>

<script src="{!! asset('/libs/jquery/dist/jquery.min.js') !!}"></script>
<script src="{!! asset('/libs/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('/libs/bootstrap-material/dist/js/material.min.js') !!}"></script>
<script src="{!! asset('/libs/masonry-layout/dist/masonry.pkgd.js') !!}"></script>
<script src="{!! asset('/js/common-ytb.js') !!}"></script>
@yield('scripts')
</body>
</html>