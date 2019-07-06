@extends('layouts.app')
@section('title', "{$song->artist} / {$song->title}")

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
  <i class="fas fa-music"></i>&nbsp;{{ $song->artist }} / {{ $song->title }}
@endslot
@slot('contents')
  <song-infomation-component :song="{{ $song }}" :my_state="{{ $my_state }}"/>
@endslot
@endcomponent
@endsection