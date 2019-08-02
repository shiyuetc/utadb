@extends('layouts.app')

@section('sidebar')
  @include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
  @component('components.section', ['hidden' => true, 'toggle' => true])
  @slot('title')
    <i class="fas fa-link"></i>&nbsp;外部関連リンク
  @endslot
  @slot('contents')
    <ul>
      <li><a class="default-link" href="https://www.joysound.com/web/" target="_blank">JOYSOUND.com</a></li>
      <li><a class="default-link" href="https://www.clubdam.com/" target="_blank">DAM CHANNEL</a></li>
    </ul>
  @endslot
  @endcomponent
  @include('widgets.tweet-notification')
@endsection

@section('content')
@component('components.section')
@slot('title')
  <i class="fab fa-react"></i>&nbsp;ローカルタイムライン
@endslot
@slot('contents')
  <timeline-component/>
@endslot
@endcomponent
@endsection