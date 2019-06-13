@extends('layouts.app')
@section('title', '新規登録')
@section('page_type', 'inner')

@section('content')
<div class="form-compact section">
  <form method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}
    <h2 class="form-title"><i class="fas fa-user"></i>&nbsp;新規登録</h2>
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
      <label for="name" class="label"><i class="fas fa-user"></i>&nbsp;名前</label>
      <input id="name" type="text" class="text" name="name" value="{{ old('name') }}" placeholder="1~20文字"
        maxlength="20" required autocomplete="off">
      @if ($errors->has('name'))
      <span class="help-block">
        <p>{{ $errors->first('name') }}</p>
      </span>
      @endif
    </div>
    <div class="form-group">
      <label for="email" class="label"><i class="fas fa-envelope"></i>&nbsp;メールアドレス(任意)</label>
      <input id="email" type="email" class="text" name="email" value="{{ old('email') }}">
      @if ($errors->has('email'))
      <span class="help-block">
        <p>{{ $errors->first('email') }}</p>
      </span>
      @endif
    </div>
    <div class="form-group">
      <label for="password" class="label"><i class="fas fa-lock"></i>&nbsp;パスワード</label>
      <input id="password" type="password" class="text" name="password" placeholder="6文字以上" pattern=".{6,}" required>
      @if ($errors->has('password'))
      <span class="help-block">
        <p>{{ $errors->first('password') }}</p>
      </span>
      @endif
    </div>
    <div class="form-group">
      <label for="password-confirm" class="label"><i class="fas fa-lock"></i>&nbsp;パスワード再確認</label>
      <input id="password-confirm" type="password" class="text" name="password_confirmation" required autocomplete="off">
    </div>
    <div class="form-group">
      <div class="checkbox">
        <label><input type="checkbox" name="agreement"><span>&nbsp;<a class="default-link on-color" href="{{ route('terms') }}" target="_blank">利用規約</a>&nbsp;に同意する</span></label>
      </div>
      @if ($errors->has('agreement'))
      <span class="help-block">
        <p>{{ $errors->first('agreement') }}</p>
      </span>
      @endif
    </div>
    <div class="form-group">
      <button type="submit" class="button button-danger">新規会員登録</button>
      <p class="supplement-text">アカウントをお持ちの方は <a class="default-link on-color" href="{{ route('login') }}">ログイン</a></p>
    </div>
  </form>
</div>
@endsection