@extends('layouts.app')
@section('title', "{$user->name}(@{$user->screen_name})さんのページ")

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])
@include('widgets.share')
@endsection

@section('content')
@component('components.section', ['toggle' => true])
@slot('title')
  <i class="fas fa-chart-bar"></i>&nbsp;分析チャート
@endslot
@slot('contents')
<analysis-chart-component :user="{{ $user }}"></analysis-chart-component>
@endslot
@endcomponent

@component('components.section')
@slot('title')
  <i class="fas fa-book"></i>&nbsp;{{ $user->name }}さんの記録
@endslot
@slot('contents')
  <timeline-component :user="{{ $user }}" :logined_id="{{ Auth::check() ? Auth::id() : -1 }}" :count="5"/>
@endslot
@endcomponent
@endsection