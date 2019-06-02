<div class="header">
  <nav class="navbar">
    <div class="navbar-container">
      <div class="navbar-left">
        <ul class="navbar-nav">
          <li class="nav-brand">
            <img src="{{ asset('images/icons/icon-32x.png') }}" alt="logo" onclick="location='{{ route('home') }}'">
            <a href="{{ route('home') }}"><span class="hidden-sm-below">&nbsp;Utadb&nbsp;</span></a>
          </li>
          @auth
          <li class="nav-item{{ Request::is('/') ? ' active' : '' }}">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i><span class="hidden-md-below">&nbsp;ホーム</span></a>
          </li>
          @endauth
        </ul>
      </div>
      <div class="navbar-right">
        <ul class="navbar-nav">
          @guest
          <li class="nav-item{{ Request::is('register') ? ' active' : '' }}">
            <a href="{{ route('register') }}"><i class="fas fa-user"></i><span
                class="hidden-sm-below">&nbsp;新規登録</span></a>
          </li>
          <li class="nav-item{{ Request::is('login') ? ' active' : '' }}">
            <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i><span
                class="hidden-sm-below">&nbsp;ログイン</span></a>
          </li>
          @else
          <li class="nav-button">
            <button id="avatar-button"><img src="{{ asset('images/sample_avatar.png') }}" alt="avatar"></button>
          </li>
          @endguest
        </ul>
        @auth
        @section('js_avatar_button', true)
        <div id="nav-dialog" class="nav-dialog">
          <ul class="dialog-group">
            <li class="dialog-item success-dialog-item">
              <a href="{{ route('user', ['id' => Auth::user()->screen_name]) }}"><i class="fa fa-user"></i>&nbsp;マイページ</a>
            </li>
          </ul>
          <ul class="dialog-group">
            <li class="dialog-item danger-dialog-item">
              <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                  class="fas fa-power-off"></i>&nbsp;ログアウト</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}</form>
            </li>
          </ul>
        </div>
        @endauth
      </div>
    </div>
  </nav>
</div>