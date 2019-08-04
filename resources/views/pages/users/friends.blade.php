@extends('layouts.app')
@section('title', "{$user->name}(@{$user->screen_name})さんのフレンド")

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])
@endsection

@section('content')
@component('components.section', ['toggle' => true])
@slot('title')
  <i class="fas fa-user-friends"></i>&nbsp;あなたが追加したフレンド
@endslot
@slot('contents')
  <user-friends-component :type="'following'" :user="{{ $user }}"></user-friends-component>
@endslot
@endcomponent

@component('components.section', ['toggle' => true])
@slot('title')
  <i class="fas fa-user-friends"></i>&nbsp;あなたを追加したフレンド
@endslot
@slot('contents')
  <user-friends-component :type="'followers'" :user="{{ $user}}"></user-friends-component>
@endslot
@endcomponent
@endsection