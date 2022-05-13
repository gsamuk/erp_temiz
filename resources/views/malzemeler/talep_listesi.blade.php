@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Zeberced ERP @endslot
@slot('title') Malzeme Talep Listesi @endslot
@endcomponent

<div class="row">
    <div class="col-xxl-12">
        @livewire('malzemeler.talep-listesi')
    </div>
</div>

@endsection
@section('script')

<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    window.addEventListener('ShowMalzemeFotoModal', event => {           
        $('#MalzemeFotoModal').modal('show');
    }); 
</script>

@endsection