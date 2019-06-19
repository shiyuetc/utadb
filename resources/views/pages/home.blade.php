@extends('layouts.app')

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
<!--@include('widgets.tweet-notification')-->
@endsection

@section('content')
<div class="section">
  <h1 class="title"><i class="fab fa-react"></i>&nbsp;ローカルタイムライン</h1>
  <timeline-component/>
</div>
@endsection