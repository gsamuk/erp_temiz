@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Zeberced ERP @endslot
@slot('title') MALZEME TALEBİ @endslot
@endcomponent

@livewire('malzemeler.taleplerim')


@endsection
@section('script')

<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>


<script>
    window.addEventListener('CloseModal', event => {            
        $('.modal').modal('hide');
    });

</script>

@endsection