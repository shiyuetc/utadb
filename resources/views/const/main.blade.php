<div class="header-push"></div>
@if(!isset($head_margin) || $head_margin)<div style="height: 12px;"></div>@endif
<div class="main">
  @if(!isset($visible_alert) || $visible_alert)@include('components.alert')@endif
  @yield('content')
</div>
@include('widgets.page-top')
<div class="height-large"></div>
<div class="footer-push"></div>