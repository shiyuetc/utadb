@extends('layouts.app')
@section('title', "{$user->name}(@{$user->screen_name})さんの{$state['jp']}")

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])
@endsection

@section('content')
@component('components.section')
@slot('title')
  <i class="{{ $state['icon-class'] }}"></i>&nbsp;{{ $state['jp'] }}
@endslot
@slot('contents')
  <user-statuses-component :user_id="'{{ $user->id }}'" :state="{{ $state['index'] }}" :page="{{ $page }}"/>
@endslot
@endcomponent
@endsection