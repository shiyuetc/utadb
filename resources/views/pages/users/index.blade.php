@extends('layouts.app')
@section('title', "{$user->name}(@{$user->screen_name})さんのページ")

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])
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
  <i class="fab fa-react"></i>&nbsp;ユーザータイムライン
@endslot
@slot('contents')
  <timeline-component :user="{{ $user }}" :count="5"/>
@endslot
@endcomponent
@endsection