@extends('layouts.app')
@section('title', 'その他')

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
@include('widgets.setting-list')
@endsection

@section('content')
@component('components.section')
@slot('title')
  <i class="fas fa-cloud-download-alt"></i>&nbsp;データのエクスポート
@endslot
@slot('contents')
<form class="form" method="GET" action="other/export">
  <p class="note">これは登録している曲を文字のみでリストとして全件表示できる機能です。</p>
  <p class="note">※表示できるデータの最大件数は10,000件までです。</p>
  <table class="setting-table">
    <tr>
      <td><label for="email" class="label"><i class="fas fa-database"></i>&nbsp;対象の項目</label></td>
      <td>
        <span class="hidden-md-above"><label for="email" class="label hidden-md-above"><i class="fas fa-database"></i>&nbsp;対象の項目</label></span>
        <select name="state" class="select">
          <option value="0">登録済みの曲</option>
          <option value="3">習得済みの曲</option>
          <option value="2">練習中の曲</option>
          <option value="1">気になるの曲</option>
        </select>
      </td>
    </tr>
    <tr>
      <td><label for="email" class="label"><i class="fas fa-sort"></i>&nbsp;並び順</label></td>
      <td>
        <span class="hidden-md-above"><label for="email" class="label hidden-md-above"><i class="fas fa-sort"></i>&nbsp;並び順</label></span>
        <select name="sort" class="select">
          <option value="artist_asc">アーティスト名(昇順)</option>
          <option value="artist_desc">アーティスト名(降順))</option>
          <option value="title_asc">曲名(昇順)</option>
          <option value="title_desc">曲名(降順))</option>
        </select>
      </td>
    </tr>
    <tr>
      <td></td>
      <td><button class="button button-info" type="submit"><i class="fas fa-plus-circle"></i>&nbsp;データを表示</button></td>
    </tr>
  </table>
</form>
@endslot
@endcomponent
@endsection