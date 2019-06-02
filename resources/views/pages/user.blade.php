@extends('layouts.app')

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])

@endsection
@section('content')
<timeline-component :timeline="'user'" :user_id="'{{ $user->id }}'"/>

@endsection