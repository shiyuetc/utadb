@extends('layouts.app')

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
<!--@include('widgets.tweet-notification')-->
@endsection

@section('content')
@component('components.section')
@slot('title')
  <i class="fab fa-react"></i>&nbsp;ローカルタイムライン
@endslot
@slot('contents')
  <timeline-component/>
@endslot
@endcomponent
@endsection