@extends('layouts.app')
@section('title', "ユーザーの検索")

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
@endsection

@section('content')
@component('components.section', ['toggle' => true])
@slot('title')
  <i class="fas fa-users"></i>&nbsp;ユーザーの検索
@endslot
@slot('contents')
  <form class="form" method="GET" action="{{ route('search.user') }}">
    <table class="form-table">
      <tr>
        <td width="100%">
          <input class="text" value="{{ Request::input('q') }}" name="q" placeholder="検索キーワード" maxlength="20" autocomplete="off">
        </td>
        <td nowrap>
          <button class="button button-info const-height"><i class="fa fa-search"></i><span class="hidden-md-below">&nbsp;検索</span></button>
        </td>
      </tr>
    </table>
  </form>
@endslot
@endcomponent

@component('components.section')
  @slot('title')
    @if(empty($q))
      <i class="fa fa-users"></i>&nbsp;ユーザー一覧
    @else
      <i class="fa fa-search"></i>&nbsp;検索結果
    @endif
  @endslot
  @slot('contents')
    <user-search-component @if(!empty($q)):keyword="'{{ $q }}'"@endif :page="{{ $page }}" />
  @endslot
@endcomponent
@endsection
