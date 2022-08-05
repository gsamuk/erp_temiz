@extends('layouts.master')
@section('title')
  @lang('translation.starter')
@endsection

@section('content')
  @include('qr_form')
@endsection
@section('script')
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
