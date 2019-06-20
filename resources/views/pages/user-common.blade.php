@extends('layouts.app')
@section('title', "{$user->name}(@{$user->screen_name})さんとの共通の曲")

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])
@endsection

@section('content')
@component('components.section')
@slot('title')
  <i class="fas fa-link"></i>&nbsp;共通の曲
@endslot
@slot('contents')
  <user-common-component :user_id="'{{ $user->id }}'" :page="{{ $page }}"/>
@endslot
@endcomponent
@endsection