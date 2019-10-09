@extends('layouts.app')
@section('title', "{$user->name}(@{$user->screen_name})さんの記録")

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])
@endsection

@section('content')
@component('components.section')
@slot('title')
  <i class="fas fa-book"></i>&nbsp;{{ $user->screen_name }}さんの記録
@endslot
@slot('contents')
  <timeline-component :user="{{ $user }}" :logined_id="{{ Auth::check() ? Auth::id() : -1 }}"/>
@endslot
@endcomponent
@endsection