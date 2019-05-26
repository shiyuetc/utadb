@extends('layouts.app')
@section('page_type', 'inner')
@php
$title = '新規登録';
@endphp

@section('content')
@include('widgets.register-form')
@endsection