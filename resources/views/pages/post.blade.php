@extends('layouts.app')
@section('title', "{$status->user->name}さんの記録の詳細")

@section('sidebar')
@auth
  @include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
@else
  @include('widgets.auth-route') 
@endauth
@endsection

@section('content')
@component('components.section')
@slot('title')
  <i class="fas fa-book"></i>&nbsp;{{ $status->user->name }}さんの記録の詳細
@endslot
@slot('contents')
  <status-infomation-component :status="{{ $status }}"/>
@endslot
@endcomponent
@endsection