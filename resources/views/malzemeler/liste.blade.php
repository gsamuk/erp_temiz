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
    window.addEventListener('CloseModal', event => {           
        $('.modal').modal('hide');
    }); 

    window.addEventListener('ShowModal', event => {           
        $('#fotoModal').modal('show');
    }); 

</script>

@endsection