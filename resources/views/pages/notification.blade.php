@extends('layouts.app')

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
@endsection

@section('content')
@component('components.section')
@slot('title')
  <i class="fas fa-bell"></i>&nbsp;通知
@endslot
@slot('contents')
  <p class="center">coming soon</p>
@endslot
@endcomponent
@endsection