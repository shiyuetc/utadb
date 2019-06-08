@extends('layouts.app')
@section('title', "{$user->name}(@{$user->screen_name})さんの{$state['jp']}")

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])
@endsection

@section('content')
<div class="section">
  <h1 class="title"><i class="{{ $state['icon-class'] }}"></i>&nbsp;{{ $state['jp'] }}</h1>
  <user-statuses-component :user_id="'{{ $user->id }}'" :state="{{ $state['index'] }}" :page="{{ $page }}"/>
</div>
@endsection