<!doctype html>
<html lang="en">
@include('layouts/blocks.head')
<body>

    @include('layouts/blocks/top-panel')

    <div class="container-fluid">
        <div class="row">
                @yield('left-panel')
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

                @yield('content')

            </div>
        </div>
    </div>
    <div id="preloader"></div>
@include('layouts/blocks.footer')
</body>
</html>