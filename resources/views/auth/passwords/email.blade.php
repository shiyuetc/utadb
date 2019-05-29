@extends('layouts.app')
@section('title', 'パスワードのリセット')
@section('page_type', 'inner')

@section('content')
<div class="form-compact section">
  <form method="POST" action="{{ route('password.email') }}">
    {{ csrf_field() }}
    <h2 class="form-title"><i class="fas fa-lock"></i>&nbsp;パスワードのリセット</h2>
    @if (session('status'))
      @include('components.alert', ['type' => 'success', 'text' => session('status')])
    @endif
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
      <button type="submit" class="button button-danger">メールを送信</button>
    </div>
  </form>
</div>
@endsection