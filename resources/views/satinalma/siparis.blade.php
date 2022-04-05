@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Zeberced ERP @endslot
@slot('title') Satınalma Siparişleri @endslot
@endcomponent

<div class="row">
    <div class="col-xxl-12">
        @livewire('satinalma.siparis')
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

    function sil(id){
        $.confirm({
        title: 'Onay',
        closeIcon:true,
        theme: 'material', 
        content: 'Bu Kayıt Silinecek emin misiniz?',
        buttons: {
                Sil: function () {
                    window.livewire.emit('SiparisSil', { id : id });
                },
                       
            }
        });        
    }


    function onay(id){
        $.confirm({
        columnClass: 'col-md-6',
        closeIcon:true,
        title: 'Onay Durumu Değiştir',
        theme: 'material', 
        content:'Sipariş Durumunu Seçiniz',       
        buttons: {
            Oneri: {
                    text: 'Öneri',
                    btnClass: 'btn-blue',                    
                    action: function(){
                        window.livewire.emit('SiparisStatus', { id : id, po_status:1 });
                    }                    
                },
                SevkEdilebilir: {
                    text: 'Sevk Edilebilir',
                    btnClass: 'btn-green',                    
                    action: function(){
                        window.livewire.emit('SiparisStatus', { id : id, po_status:4 });
                    }                    
                },
                SevkEdilemez:  {
                    text: 'Sevk Edilemez',
                    btnClass: 'btn-red',                    
                    action: function(){
                        window.livewire.emit('SiparisStatus', { id : id, po_status:2 });
                    }
                },

                     
            }
        });        
    }


</script>

@endsection