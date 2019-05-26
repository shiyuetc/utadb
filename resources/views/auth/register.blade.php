@extends('layouts.app')
@php
$title = '新規登録';
$visible_alert = false;
@endphp

@section('content')
<div class="margin-const">
  @include('widgets.register-form')
</div>
@endsection