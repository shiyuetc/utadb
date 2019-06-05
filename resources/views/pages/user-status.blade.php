@extends('layouts.app')
@section('title', "{$user->name}(@{$user->screen_name})さんの{$state['jp']}")

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])
@endsection

@section('content')
<user-statuses-component :state="'{{ $state['index'] }}'" :user_id="'{{ $user->id }}'"/>
@endsection