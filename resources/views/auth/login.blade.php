@extends('layouts.app')
@section('title', 'ログイン')
@section('page_type', 'inner')

@section('content')
<div class="form-compact section">
  <form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
    <h2 class="form-title"><i class="fas fa-sign-in-alt"></i>&nbsp;ログイン</h2>
    <div class="form-group">
      <label for="screen-name" class="label"><i class="fas fa-at"></i>&nbsp;ユーザーID</label>
      <input id="screen-name" type="text" class="text" name="screen_name" value="{{ old('screen_name') }}"
        placeholder="1~15文字" maxlength="15" pattern="^[a-zA-Z0-9_]{1,15}$" required autocomplete="off">
      @if ($errors->has('screen_name'))
      <span class="help-block">
        <p>{{ $errors->first('screen_name') }}</p>
      </span>
      @endif
    </div>
    <div class="form-group">
      <label for="password" class="label"><i class="fas fa-lock"></i>&nbsp;パスワード</label>
      <input id="password" type="password" class="text" name="password" pattern=".{6,}" required>
      @if ($errors->has('password'))
      <span class="help-block">
        <p>{{ $errors->first('password') }}</p>
      </span>
      @endif
    </div>
    <div class="form-group">
      <div class="checkbox">
        <label><input type="checkbox" name="remember"
            {{ old('remember') ? 'checked' : '' }}><span>&nbsp;ログイン情報を保存</span></label>
      </div>
    </div>
    <div class="form-group">
      <button type="submit" class="button button-danger">ログイン</button>
      <p class="supplement-text">アカウントを持っていない方は <a href="{{ route('register') }}">新規登録</a></p>
    </div>
  </form>
</div>
<p class="supplement-title"><a href="{{ route('password.request') }}">パスワードを忘れた場合はこちら</a></p>
@endsection