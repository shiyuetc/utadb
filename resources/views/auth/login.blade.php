@extends('layouts.app')
@section('page_type', 'inner')
@php
$title = 'ログイン';
@endphp

@section('content')
@include('widgets.login-form')
@endsection