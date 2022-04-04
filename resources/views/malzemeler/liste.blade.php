@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Zeberced ERP @endslot
@slot('title') Malzemeler @endslot
@endcomponent

@livewire('malzemeler.liste')


@endsection
@section('script')

<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

@endsection