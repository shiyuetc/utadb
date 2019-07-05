@extends('layouts.app')
@section('title', "{$status->song->artist} / {$status->song->title}")

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
  <i class="fas fa-music"></i>&nbsp;{{ $status->song->artist }} / {{ $status->song->title }}
@endslot
@slot('contents')
  <song-infomation-component :status="{{ $status }}"/>
@endslot
@endcomponent
@endsection