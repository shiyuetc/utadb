@extends('layouts.app')
@section('title', 'エクスポート')

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
@include('widgets.tool-list')
@endsection

@section('content')
@component('components.section')
@slot('title')
<i class="fas fa-cloud-download-alt"></i>&nbsp;エクスポート
@endslot
@slot('contents')
<form class="form" method="GET" action="#">
  <p class="note">これは登録している曲を文字のみでリストとして全件表示できる機能です。</p>
  <p class="note">※表示できるデータの最大件数は10,000件までです。</p>
  <table class="setting-table">
    <tr>
      <td><label for="state" class="label"><i class="fas fa-database"></i>&nbsp;対象の項目</label></td>
      <td>
        <span class="hidden-md-above"><label for="state" class="label hidden-md-above"><i class="fas fa-database"></i>&nbsp;対象の項目</label></span>
        <select name="state" class="select">
          <option value="0">登録済みの曲</option>
          <option value="3"@if($options["state"] == 3) selected @endif>習得済みの曲</option>
          <option value="2"@if($options["state"] == 2) selected @endif>練習中の曲</option>
          <option value="1"@if($options["state"] == 1) selected @endif>気になるの曲</option>
        </select>
      </td>
    </tr>
    <tr>
      <td><label for="sort" class="label"><i class="fas fa-sort"></i>&nbsp;並び順</label></td>
      <td>
        <span class="hidden-md-above"><label for="sort" class="label hidden-md-above"><i class="fas fa-sort"></i>&nbsp;並び順</label></span>
        <select name="sort" class="select">
          <option value="artist_asc">アーティスト名(昇順)</option>
          <option value="artist_desc"@if($options["sort"] == 'artist_desc') selected @endif>アーティスト名(降順))</option>
          <option value="title_asc"@if($options["sort"] == 'title_asc') selected @endif>曲名(昇順)</option>
          <option value="title_desc"@if($options["sort"] == 'title_desc') selected @endif>曲名(降順))</option>
        </select>
      </td>
    </tr>
    <tr>
      <td><label for="view" class="label"><i class="fas fa-tasks"></i>&nbsp;表示形式</label></td>
      <td>
        <span class="hidden-md-above"><label for="view" class="label hidden-md-above"><i class="fas fa-tasks"></i>&nbsp;表示形式</label></span>
        <select name="view" class="select">
          <option value="table">テーブル形式</option>
          <option value="csv"@if($options["view"] == 'csv') selected @endif>CSV形式</option>
          <option value="json"@if($options["view"] == 'json') selected @endif>JSON形式</option>
        </select>
      </td>
    </tr>
    <tr>
      <td></td>
      <td><button class="button button-info" type="submit"><i class="fas fa-sync-alt"></i>&nbsp;データを更新</button></td>
    </tr>
  </table>
</form>
@if($options["view"] == 'csv')
<div class="fill">
@foreach($data as $song)
  {{ $song->artist }}, {{ $song->title }}<br>
@endforeach
</div>
@elseif($options["view"] == 'json')
<div class="fill">
  {{ json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) }}
</div>
@else
<table class="object-table">
  <thead>
    <tr>
      <th class="left-bring">アーティスト名</th>
      <th class="left-bring">曲名</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data as $song)
    <tr>
      <td>{{ $song->artist }}</td>
      <td>{{ $song->title }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endif

@endslot
@endcomponent
@endsection