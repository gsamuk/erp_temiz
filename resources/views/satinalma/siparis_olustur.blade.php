@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Zeberced ERP @endslot
@slot('title') Satınalma Siparişi @endslot
@endcomponent


@livewire('satinalma.siparis-olustur', ['sid' => $id])


@endsection
@section('script')

<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

<script>
    var myModal = new bootstrap.Modal(document.getElementById('malzemeModal'), {keyboard: false}).hide();
    window.addEventListener('CloseModal', event => {           
        $('.modal').modal('hide');
    });


    window.addEventListener('Hesapla', event => {           
        var toplam = 0;
        $('input[name=tutar]').each(function() {
            toplam = parseInt(toplam) + parseInt($(this).val());            
         });
         $('#div_toplam').html(toplam);

        var net_tutar = 0;
        $('input[name=net_tutar]').each(function() {
            net_tutar = parseInt(net_tutar) + parseInt($(this).val());            
         });
         $('#div_net_toplam').html(net_tutar);
         
         //$('#div_kdv').html(parseInt(net_tutar) - parseInt(toplam));


    });

    
  

    

</script>

@endsection