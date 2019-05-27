@extends('layouts.app')

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user()])
@include('widgets.tweet-notification')

@endsection
@section('content')
<timeline-component/>

@endsection