@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Zeberced ERP @endslot
@slot('title') Malzeme Fotoğraf Yönetimi @endslot
@endcomponent

@livewire('malzemeler.fotograf')

@endsection
@section('script')

<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection