@extends('layouts.app')
@section('title', "{$status->song->artist} / {$status->song->title}")

@section('sidebar')
@if(Auth::check())
  @include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
@else
  @include('widgets.auth-route') 
@endif
@endsection

@section('content')
<div class="section">
  <h1 class="title"><i class="fas fa-music"></i>&nbsp;{{ $status->song->artist }} / {{ $status->song->title }}</h1>
  <song-infomation-component :status="{{ $status }}"/>
</div>
@endsection