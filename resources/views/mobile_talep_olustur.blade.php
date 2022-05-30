@extends('mobile_layouts.master')

@section('content')

@if(isset($sku))

@livewire('malzemeler.mobile.liste', ['sku' => $sku])
@else
@livewire('malzemeler.mobile.liste')
@endif

@endsection