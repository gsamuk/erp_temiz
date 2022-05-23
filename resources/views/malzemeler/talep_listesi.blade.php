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


    window.addEventListener('TalepRedToast', event => {                   
        Toastify({
            text: "Talep tamamen reddedildi.",
            gravity: "top",  
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            },
            position: "center",  
            duration: 3000
            }).showToast();
    });    

</script>

@endsection