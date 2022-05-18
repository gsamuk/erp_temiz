<!doctype html>
<html lang="en">

<head>
    @include('mobile_layouts.head')
</head>

<body>
    @include("mobile_layouts.header")
    @yield('content')

    @include("mobile_layouts.side_bar")
    @include("mobile_layouts.js")
</body>

</html>