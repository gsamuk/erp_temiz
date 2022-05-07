@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Zeberced ERP @endslot
@slot('title') Malzeme Talebi @endslot
@endcomponent

@livewire('malzemeler.talep-olustur')


@endsection
@section('script')

<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>


<script>
    window.addEventListener('CloseModal', event => {           
        $('.modal').modal('hide');
    });

</script>

@endsection