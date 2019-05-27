@extends('layouts.app')

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user()])
@endsection
@section('content')
<div class="section">
  b
</div>
@endsection
