@extends('layouts.app')
@section('title', "{$user->name}(@{$user->screen_name})さんの記録")

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])
@endsection

@section('content')
@component('components.section')
@slot('title')
  <i class="fab fa-react"></i>&nbsp;ユーザータイムライン
@endslot
@slot('contents')
  <timeline-component :user_id="'{{ $user->id }}'"/>
@endslot
@endcomponent
@endsection