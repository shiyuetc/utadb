<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  @include('const.head')
</head>
<body>
  <div id="app">
    @include('const.header')
    @include('const.main')
  </div>
  @include('const.footer')
</body>
</html>