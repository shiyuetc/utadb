@extends('layouts.app')
@section('title', "検索")

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hide' => true])

@endsection
@section('content')
<search-song-component/>
@endsection