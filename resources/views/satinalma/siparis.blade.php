@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Zeberced ERP @endslot
@slot('title') Satınalma Siparişi @endslot
@endcomponent

@livewire('satinalma.siparis')


@endsection
@section('script')

<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

<script>
    var myModal = new bootstrap.Modal(document.getElementById('malzemeModal'), {keyboard: false}).hide();
    window.addEventListener('CloseModal', event => {           
        $('.modal').modal('hide');
    });

    window.addEventListener('SetDisable', event => {                  
         $("#input_aciklama_"+event.detail.line).prop("disabled", true);
         $("#input_kod_"+event.detail.line).prop("disabled", true);
    });
    
</script>

@endsection