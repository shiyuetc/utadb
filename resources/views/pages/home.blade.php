@extends('layouts.app')

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hide' => true])
@include('widgets.tweet-notification')
@endsection

@section('content')
<timeline-component/>
@endsection