@extends('layouts.app')
@php
$title = 'ログイン';
$visible_alert = false;
@endphp

@section('content')
<div class="margin-const">
  @include('widgets.login-form')
</div>
@endsection