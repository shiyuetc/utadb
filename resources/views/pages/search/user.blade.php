@extends('layouts.app')
@section('title', "ユーザーの検索")

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hide' => true])
@endsection

@section('content')
<div class="section">
  <h1 class="title"><i class="fas fa-users"></i>&nbsp;ユーザーの検索</h1>
  <form class="form" method="GET" action="{{ route('search.user') }}">
    <table class="form-table">
      <tr>
        <td width="100%">
          <input class="text" value="{{ Request::input('q') }}" name="q" placeholder="検索キーワード" maxlength="20" autocomplete="off" required>
        </td>
        <td nowrap>
          <button class="button button-info const-height"><i class="fa fa-search"></i><span class="hidden-md-below">&nbsp;検索</span></button>
        </td>
      </tr>
    </table>
  </form>
</div>
@if(isset($q) && $q != '')
<div class="section">
  <h1 class="title"><i class="fa fa-search"></i>&nbsp;検索結果</h1>
  <search-user-component :q="'{{ urlencode($q) }}'" :page="{{ $page }}"/>
</div>
@endif
@endsection