@extends('layouts.app')
@section('title', 'アカウントの削除')

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hide' => true])
@include('widgets.setting-list')
@endsection

@section('content')
<div class="section">
  <h1 class="title"><i class="fas fa-key"></i>&nbsp;アカウントの削除</h1>
  <form class="form" method="POST" action="{{ route('settings.deactivate') }}">
    {{ csrf_field() }}
    <p class="note">※アカウント削除申請から7日後に対象のアカウントが削除され使用できなくなり、元の状態に戻すことはできませんが、それまでに申請を解除することで削除申請を無効化できます。</p>
    <table class="setting-table">
      <tr>
        <td><label for="password_old" class="label"><i class="fa fa-lock"></i>&nbsp;パスワード</label></td>
        <td>
          <span class="hidden-md-above"><label for="password_old" class="label hidden-md-above"><i class="fa fa-lock"></i>&nbsp;パスワード</label></span>
          <input id="password-old" type="password" class="text" name="password_old" pattern=".{6,}" required autocomplete="off">
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          @if(!$isApplied)
          <button class="button button-danger" type="submit" name="appli" value="request">アカウント削除申請</button>
          @else
          <button class="button button-success" type="submit" name="cancel" value="request">削除申請を解除</button>
          @endif
        </td>
      </tr>
    </table>
  </form>
</div>
@endsection