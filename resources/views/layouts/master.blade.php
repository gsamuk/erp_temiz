<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light"
    data-sidebar="dark" data-sidebar-size="lg">

<head>
    <meta charset="utf-8" />
    <title>Dekatek Online ERP | Zeberced</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Zeberced için hazırlanmış Logo Tiger ERP eklentisidir." name="description" />
    <meta content="Dekatek" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('layouts.head-css')
    @livewireStyles
</head>

@section('body')
@include('layouts.body')
@show
<!-- Begin page -->
<div id="layout-wrapper">
    @include('layouts.topbar')
    @include('layouts.sidebar')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid p-0">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('layouts.footer')
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

@include('layouts.customizer')

<!-- JAVASCRIPT -->
@include('layouts.vendor-scripts')
@livewireScripts

<script>
    window.addEventListener('OpenModal', event => {            
        $(event.detail.ModalName).modal('show');
    }); 
    window.addEventListener('CloseModal', event => {            
        $(event.detail.ModalName).modal('hide');
    });

</script>
</body>

</html>