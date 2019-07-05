@extends('layouts.app')
@section('title', "")

@section('sidebar')
@if(Auth::check())
  @include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
@else
  @include('widgets.auth-route') 
@endif
@endsection

@section('content')

@endsection