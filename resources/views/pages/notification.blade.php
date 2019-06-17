@extends('layouts.app')

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hide' => true])
@endsection

@section('content')
<div class="section">
  <h1 class="title"><i class="fas fa-bell"></i>&nbsp;通知</h1>
  <p>comming soon</p>
</div>
@endsection