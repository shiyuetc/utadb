@extends('layouts.app')
@section('title', 'プロフィールの設定')

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
@include('widgets.setting-list')
@endsection

@section('content')
@component('components.section')
@slot('title')
  <i class="far fa-address-card"></i>&nbsp;プロフィールの編集
@endslot
@slot('contents')
  <form class="form" method="POST" action="{{ route('settings.profile.update') }}">
    {{ csrf_field() }}
    <table class="setting-table">
      <tr>
        <td><label for="name" class="label"><i class="fa fa-user"></i>&nbsp;ユーザー名</label></td>
        <td>
          <span class="hidden-md-above"><label for="name" class="label hidden-md-above"><i class="fa fa-user"></i>&nbsp;ユーザー名</label></span>
          <input id="name" type="text" class="text" name="name" value="{{ Auth::user()->name }}" placeholder="1~20文字" maxlength="20" required autocomplete="off">
        </td>
      </tr>
      <tr>
        <td><label for="description" class="label"><i class="fa fa-info"></i>&nbsp;一言メッセージ</label></td>
        <td>
          <span class="hidden-md-above"><label for="description" class="label"><i class="fa fa-info"></i>&nbsp;一言メッセージ</label></span>
          <textarea class="text" name="description" rows="6" placeholder="255文字まで" maxlength="255">{{ Auth::user()->description }}</textarea>
        </td>
      </tr>
      <tr>
        <td><label class="label"><i class="fa fa-image"></i>&nbsp;プロフィール画像</label></td>
        <td>
          <span class="hidden-md-above"><label class="label"><i class="fa fa-image"></i>&nbsp;プロフィール画像</label></span>
          <avatar-categories-component/>
        </td>
      </tr>
      <tr>
        <td></td>
        <td><button class="button button-info" type="submit">編集を保存</button></td>
      </tr>
    </table>
  </form>
@endslot
@endcomponent
@endsection