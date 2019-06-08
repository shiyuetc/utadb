@extends('layouts.app')
@section('title', "{$song->artist} / {$song->title}")

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hide' => true])

@endsection
@section('content')
<div class="section">
  <h1 class="title"><i class="fas fa-music"></i>&nbsp;{{ $song->artist }} / {{ $song->title }}</h1>
  <song-infomation-component :song="{{ $song }}"/>
</div>
@endsection