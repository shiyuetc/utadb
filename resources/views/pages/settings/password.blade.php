@extends('layouts.app')

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hide' => true])
@include('widgets.setting-list')
@endsection

@section('content')
<div class="section">
  <h1 class="title"><i class="fas fa-key"></i>&nbsp;パスワードの変更</h1>
  <form class="form" method="POST" action="{{ route('settings.password') }}">
    {{ csrf_field() }}
    <table class="setting-table">
      <tr>
        <td><label for="password_old" class="label"><i class="fa fa-lock"></i>&nbsp;現在のパスワード</label></td>
        <td>
          <span class="hidden-md-above"><label for="password_old" class="label hidden-md-above"><i class="fa fa-lock"></i>&nbsp;現在のパスワード</label></span>
          <input id="password-old" type="password" class="text" name="password_old" pattern=".{6,}" required autocomplete="off">
        </td>
      </tr>
      <tr>
        <td><label for="password" class="label"><i class="fa fa-lock"></i>&nbsp;新しいパスワード</label></td>
        <td>
          <span class="hidden-md-above"><label for="password" class="label hidden-md-above"><i class="fa fa-lock"></i>&nbsp;新しいパスワード</label></span>
          <input id="password" type="password" class="text" name="password" placeholder="6文字以上" pattern=".{6,}" required autocomplete="off">
        </td>
      </tr>
      <tr>
        <td><label for="password-confirm" class="label"><i class="fa fa-lock"></i>&nbsp;パスワード再確認</label></td>
        <td>
          <span class="hidden-md-above"><label for="password-confirm" class="label hidden-md-above"><i class="fa fa-lock"></i>&nbsp;パスワード再確認</label></span>
          <input id="password-confirm" type="password" class="text" name="password_confirmation" placeholder="パスワード確認用" pattern=".{6,}" required autocomplete="off">
        </td>
      </tr>
      <tr>
        <td></td>
        <td><button class="button button-info" type="submit">編集を保存</button></td>
      </tr>
    </table>
  </form>
</div>
@endsection