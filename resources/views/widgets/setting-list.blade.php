@component('components.section', ['toggle' => true])
@slot('title')
  <i class="fas fa-cog"></i>&nbsp;設定
@endslot
@slot('contents')
  <ul class="setting-list list">
    <li class="{{ Request::is('settings/profile') ? ' active' : '' }}"><a href="{{ route('settings.profile') }}"><i class="far fa-address-card"></i>&nbsp;プロフィールの設定<span class="right-icon"><i class="fas fa-angle-double-right"></i></span></a></li>
    <li class="{{ Request::is('settings/account') ? ' active' : '' }}"><a href="{{ route('settings.account') }}"><i class="fas fa-user"></i>&nbsp;アカウントの設定<span class="right-icon"><i class="fas fa-angle-double-right"></i></span></a></li>
  </ul>
@endslot
@endcomponent