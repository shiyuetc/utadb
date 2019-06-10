@extends('layouts.app')
@section('title', "{$status->song->artist} / {$status->song->title}")

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hide' => true])
@endsection

@section('content')
<div class="section">
  <h1 class="title"><i class="fas fa-music"></i>&nbsp;{{ $status->song->artist }} / {{ $status->song->title }}</h1>
  <song-infomation-component :status="{{ $status }}"/>
</div>
@endsection