<div class="section">
  <h1 class="title"><i class="fas fa-cog"></i>&nbsp;設定</h1>
  <ul class="setting-list list">
    <li class="{{ Request::is('settings/account') ? ' active' : '' }}"><a href="{{ route('settings.account') }}"><i class="fas fa-user"></i>&nbsp;アカウントの設定<span class="right-icon"><i class="fas fa-angle-double-right"></i></span></a></li>
  </ul>
</div>