@extends('layouts.master-without-nav')
@section('title')
@lang('translation.signin')
@endsection
@section('content')
@livewireStyles

@livewire('user.login-page')

@endsection

@section('script')
@livewireScripts
<script src="assets/libs/particles.js/particles.js.min.js"></script>
<script src="assets/js/pages/particles.app.js"></script>

@endsection