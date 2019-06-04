@extends('layouts.app')
@section('title', "{$user->name}(@{$user->screen_name})さんのページ")

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])

@endsection
@section('content')
<timeline-component :user_id="'{{ $user->id }}'"/>
@endsection