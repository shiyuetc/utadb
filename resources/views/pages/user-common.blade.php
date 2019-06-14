@extends('layouts.app')
@section('title', "{$user->name}(@{$user->screen_name})さんとの共通の曲")

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])
@endsection

@section('content')
<div class="section">
  <h1 class="title"><i class="fas fa-link"></i>&nbsp;共通の曲</h1>
  <user-common-component :user_id="'{{ $user->id }}'" :page="{{ $page }}"/>
</div>
@endsection