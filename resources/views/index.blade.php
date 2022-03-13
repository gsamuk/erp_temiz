@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Pages @endslot
@slot('title') Starter @endslot
@endcomponent

@livewire('dashboard',['d1' => 55, 'd2'=>56 ])


@endsection
@section('script')


<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

@endsection