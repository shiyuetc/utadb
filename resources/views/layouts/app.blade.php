<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  @include('widget.head')
</head>
<body>
  <div id="app">
    @include('widget.header')
    <div class="main">
      @yield('content')
    </div>
    <div class="footer-push"></div>
  </div>
  @include('widget.footer')
</body>
</html>