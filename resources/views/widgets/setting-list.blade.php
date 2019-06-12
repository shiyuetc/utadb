<div class="section">
  <h1 class="title"><i class="fas fa-cog"></i>&nbsp;アカウントの設定</h1>
  <ul class="setting-list list">
    <li class="{{ Request::is('settings/profile') ? ' active' : '' }}"><a href="{{ route('settings.profile') }}"><i class="fas fa-user"></i>&nbsp;プロフィールの編集<span class="right-icon"><i class="fas fa-angle-double-right"></i></span></a></li>
  </ul>
</div>