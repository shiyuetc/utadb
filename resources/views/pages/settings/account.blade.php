@extends('layouts.app')
@section('title', 'アカウントの設定')

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
@include('widgets.setting-list')
@endsection

@section('content')
@component('components.section')
@slot('title')
  <i class="fa fa-envelope"></i>&nbsp;メールアドレスの変更
@endslot
@slot('contents')
  <form class="form" method="POST" action="{{ route('settings.account.email') }}">
    {{ csrf_field() }}
    <table class="setting-table">
      <tr>
        <td><label for="email" class="label"><i class="fa fa-envelope"></i>&nbsp;メールアドレス</label></td>
        <td>
          <span class="hidden-md-above"><label for="email" class="label hidden-md-above"><i class="fa fa-envelope"></i>&nbsp;メールアドレス</label></span>
          <input id="email" type="email" class="text" name="email" value="{{ Auth::user()->email }}" autocomplete="off">
        </td>
      </tr>
      <tr>
        <td></td>
        <td><button class="button button-info" type="submit">変更を保存</button></td>
      </tr>
    </table>
  </form>
@endslot
@endcomponent

@component('components.section')
@slot('title')
  <i class="fas fa-key"></i>&nbsp;パスワードの変更
@endslot
@slot('contents')
  <form class="form" method="POST" action="{{ route('settings.account.password') }}">
    {{ csrf_field() }}
    <table class="setting-table">
      <tr>
        <td><label for="password-old" class="label"><i class="fa fa-lock"></i>&nbsp;現在のパスワード</label></td>
        <td>
          <span class="hidden-md-above"><label for="password-old" class="label hidden-md-above"><i class="fa fa-lock"></i>&nbsp;現在のパスワード</label></span>
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
        <td><button class="button button-info" type="submit">変更を保存</button></td>
      </tr>
    </table>
  </form>
@endslot
@endcomponent

@component('components.section')
@slot('title')
  <i class="fas fa-user-alt-slash"></i>&nbsp;アカウントの削除
@endslot
@slot('contents')
  <form class="form" method="POST" action="{{ !$isApplied ? route('settings.account.deactivate') : route('settings.account.undeactivate') }}">
    {{ csrf_field() }}
    <p class="note">※アカウント削除申請から7日後に対象のアカウントが削除され使用できなくなり、元の状態に戻すことはできませんが、それまでに申請を解除することで削除申請を無効化できます。</p>
    <table class="setting-table">
      <tr>
        <td><label for="password-old2" class="label"><i class="fa fa-lock"></i>&nbsp;パスワード</label></td>
        <td>
          <span class="hidden-md-above"><label for="password-old2" class="label hidden-md-above"><i class="fa fa-lock"></i>&nbsp;パスワード</label></span>
          <input id="password-old2" type="password" class="text" name="password_old" pattern=".{6,}" required autocomplete="off">
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          @if(!$isApplied)
          <button class="button button-danger" type="submit">アカウント削除申請</button>
          @else
          <button class="button button-success" type="submit">削除申請を解除</button>
          @endif
        </td>
      </tr>
    </table>
  </form>
@endslot
@endcomponent
@endsection