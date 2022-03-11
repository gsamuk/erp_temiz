@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') ERP @endslot
@slot('title') Kullanıcı & Yetki Yönetimi @endslot
@endcomponent


@livewire('user-list-table')


@endsection

@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script type="text/javascript">
  document.addEventListener('livewire:load', () => {   
      window.livewire.on('CloseWin', () => {
            console.log("CloseWin");   
      });
    });
</script>


@endsection