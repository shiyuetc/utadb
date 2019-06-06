@extends('layouts.app')
@section('title', "{$song->artist} / {$song->title}")

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hide' => true])

@endsection
@section('content')
<song-infomation-component :song="{{ $song }}"/>
@endsection