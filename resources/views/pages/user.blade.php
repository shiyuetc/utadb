@extends('layouts.app')

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])

@endsection
@section('content')
@if(Request::is("@{$user->screen_name}"))
  <timeline-component :type="'user'" :user_id="'{{ $user->id }}'"/>
@elseif(Request::is("@{$user->screen_name}/status/*"))
  <user-statuses-component :type="'{{ $state }}'" :user_id="'{{ $user->id }}'"/>
@endif
@endsection