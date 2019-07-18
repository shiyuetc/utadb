@extends('layouts.app')
@section('title', "{$artist->name}")

@section('sidebar')
@if(Auth::check())
  @include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
@else
  @include('widgets.auth-route') 
@endif
@endsection

@section('content')
@component('components.section', ['toggle' => true])
@slot('title')
  <i class="fas fa-music"></i>&nbsp;ローカルの{{ $artist->name }}の曲
@endslot
@slot('contents')
  <song-from-artist-component :id="'{{ $artist->id }}'"></song-from-artist-component>
@endslot
@endcomponent
@component('components.section')
@slot('title')
  <i class="fas fa-music"></i>&nbsp;{{ $artist->id[0] == 0 ? 'iTunes' : 'DAM' }}の{{ $artist->name }}の曲
@endslot
@slot('contents')
  <song-from-artist-component :source="{{ $artist->id[0] }}" :id="'{{ $artist->id }}'"></song-from-artist-component>
@endslot
@endcomponent
@endsection