<nav class="navbar">
  <div class="navbar-container">
    <div class="navbar-left">
      <ul class="navbar-nav">
        <li class="nav-brand">
          <img src="{{ asset('images/icons/icon-32x.png') }}" alt="logo" onclick="location='{{ route('home') }}'">
          <a href="{{ route('home') }}"><span class="hidden-sm-below">&nbsp;Utadb</span></a>
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
      <li class="nav-item{{ Request::is('login') ? ' active' : '' }}">
          <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i><span class="hidden-sm-below">&nbsp;ログイン</span></a>
        </li>
        <li class="nav-item{{ Request::is('register') ? ' active' : '' }}">
          <a href="{{ route('register') }}"><i class="fas fa-user"></i><span class="hidden-sm-below">&nbsp;新規登録</span></a>
        </li>
        @else
        <li class="nav-item">
          <button id="avatar-button"><img src="{{ asset('images/sample_avatar.png') }}" alt="avatar"></button>
        </li>
        @endguest
      </ul>
    </div>
  </div>
  @auth
  <div id="nav-dialog" class="nav-dialog">
    <ul class="dialog-group">
      <li class="dialog-item success-dialog-item">
        <a href=""><i class="fa fa-user"></i>&nbsp;マイページ</a>
      </li>
    </ul>
    <ul class="dialog-group">
      <li class="dialog-item danger-dialog-item">
        <a href=""><i class="fa fa-user"></i>&nbsp;ログアウト</a>
      </li>
      </ul>
  </div>
  @endauth
</nav>
@auth
<script type="text/javascript">
document.getElementById("avatar-button").onclick = function() { 
  var dialog = $("#nav-dialog");
  if(dialog.hasClass("active")) {
		dialog.fadeOut('fast');
	} else {
    dialog.fadeIn('fast');
  }
  dialog.toggleClass("active");
	$("#avatar-button").parent().toggleClass("active");
};
document.getElementById("avatar-button").onblur = function() { 
  var dialog = $("#nav-dialog");
  if(dialog.hasClass("active")) {
		dialog.fadeOut('fast');
		dialog.removeClass("active");
		$("#avatar-button").parent().removeClass("active");
	}
};
</script>
@endauth