@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') ERP @endslot
@slot('title') Çalışılacak Firma Seçimi @endslot
@endcomponent


<div class="row">
    <div class="col-md-12 col-lg-6">
        <div class="card border card-border-secondary">
            <div class="card-header">
                <h6 class="card-title mb-0">Lütfen Firma Seçin </h6>
            </div>
            <div class="card-body">
                <p class="card-text">LOGO ile senkroniyazsonu sağlamak için çalışma yapacağınız firmayı seçmelisiniz.
                </p>
                @livewire('user.firma-sec')
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection