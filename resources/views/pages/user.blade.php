@extends('layouts.app')
@section('title', "{$user->name}(@{$user->screen_name})さんのページ")

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])
@endsection

@section('content')
@component('components.section')
@slot('title')
  <i class="fas fa-chart-bar"></i>&nbsp;分析データ
@endslot
@slot('contents')
<artist-rate-pie-component :user_id="'{{ $user->id }}'" :registered_count="{{ $user->stacked_count + $user->training_count + $user->mastered_count }}"></artist-rate-pie-component>
<status-stacked-component :user_id="'{{ $user->id }}'"></status-stacked-component>
@endslot
@endcomponent

@component('components.section')
@slot('title')
  <i class="fab fa-react"></i>&nbsp;ユーザータイムライン
@endslot
@slot('contents')
  <timeline-component :user_id="'{{ $user->id }}'" :screen_name="'{{ $user->screen_name }}'" :count="5"/>
@endslot
@endcomponent
@endsection