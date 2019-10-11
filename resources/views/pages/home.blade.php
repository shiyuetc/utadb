@extends('layouts.app')

@section('sidebar')
  @include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
  @include('widgets.outer-link-list')
  @include('widgets.tweet-notification')
@endsection

@section('content')
@component('components.section')
@slot('title')
  <i class="fas fa-book"></i>&nbsp;みんなの記録
@endslot
@slot('contents')
  <timeline-component :logined_id="{{ Auth::check() ? Auth::id() : -1 }}"/>
@endslot
@endcomponent
@endsection