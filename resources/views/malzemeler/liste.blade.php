@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Zeberced ERP @endslot
@slot('title') Malzeme Listesi @endslot
@endcomponent

@livewire('malzemeler.liste-detayli',['ch' => false])


@endsection
@section('script')

<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

@endsection