@extends('layouts.master')
@section('title')
  @lang('translation.starter')
@endsection

@section('content')
  @livewire('dashboard')
@endsection
@section('script')
  <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
