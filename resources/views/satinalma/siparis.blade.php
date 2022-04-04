@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Zeberced ERP @endslot
@slot('title') Satınalma Siparişleri @endslot
@endcomponent

<div class="row">
    <div class="col-xxl-7">
        @livewire('satinalma.siparis', ['po_status' => 1, 'title' => 'Sipariş Öneri (Onay Bekleyen)'])
    </div>
    <div class="col-xxl-7">
        @livewire('satinalma.siparis', ['po_status' => 4, 'title' => 'Sevkedilebilir Sipariş (Onayladı)'])
    </div>
    <div class="col-xxl-5">
        @livewire('satinalma.siparis', ['po_status' => 2, 'title' => 'Sevkedilemez Sipariş (Red)'])

    </div>
</div>

@endsection
@section('script')

<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

<script>
    var myModal = new bootstrap.Modal(document.getElementById('malzemeModal'), {keyboard: false}).hide();
    window.addEventListener('CloseModal', event => {           
        $('.modal').modal('hide');
    });
</script>

@endsection