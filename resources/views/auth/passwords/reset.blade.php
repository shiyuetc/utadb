@extends('layouts.app')
@section('title', 'パスワードのリセット')
@section('page_type', 'inner')

@section('content')
<div class="form-compact section">
  <form method="POST" action="{{ route('password.request') }}">
    {{ csrf_field() }}
    <h2 class="form-title"><i class="fas fa-lock"></i>&nbsp;パスワードのリセット</h2>
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="form-group">
      <label for="email" class="label"><i class="fas fa-envelope"></i>&nbsp;メールアドレス</label>
      <input id="email" type="email" class="text" name="email" value="{{ old('email') }}" required>
      @if ($errors->has('email'))
      <span class="help-block">
        <p>{{ $errors->first('email') }}</p>
      </span>
      @endif
    </div>
    <div class="form-group">
      <label for="password" class="label"><i class="fas fa-lock"></i>&nbsp;新しいパスワード</label>
      <input id="password" type="password" class="text" name="password" placeholder="6文字以上" pattern=".{6,}" required>
      @if ($errors->has('password'))
      <span class="help-block">
        <p>{{ $errors->first('password') }}</p>
      </span>
      @endif
    </div>
    <div class="form-group">
      <label for="password-confirm" class="label"><i class="fas fa-lock"></i>&nbsp;パスワード再確認</label>
      <input id="password-confirm" type="password" class="text" name="password_confirmation" required
        autocomplete="off">
    </div>
    <div class="form-group">
      <button type="submit" class="button button-danger">パスワードをリセット</button>
    </div>
  </form>
</div>
@endsection