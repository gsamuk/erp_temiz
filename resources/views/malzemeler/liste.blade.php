@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Zeberced ERP @endslot
@slot('title') Malzeme Listesi @endslot
@endcomponent

@livewire('malzemeler.liste',['ch' => false])


@endsection
@section('script')

<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    window.addEventListener('ShowMalzemeFotoModal', event => {           
        $('#MalzemeFotoModal').modal('show');
    }); 
</script>
@endsection