@extends('layouts.app')
@section('title', "{$user->name}(@{$user->screen_name})さんのページ")

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])

@endsection
@section('content')
<div class="section">
  <h1 class="title">
    <i class="fab fa-react"></i>&nbsp;ユーザータイムライン
  </h1>
  <timeline-component :user_id="'{{ $user->id }}'"/>
</div>
@endsection