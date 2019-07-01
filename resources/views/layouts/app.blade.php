@section('page_type', 'standard')
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  @include('const.head')
</head>
<body>
  <div id="app">
    @include('const.header')
    <div class="header-push"></div>
    @if($__env->yieldContent('page_type') == 'standard')
      @include('const.main-standard')
    @elseif($__env->yieldContent('page_type') == 'inner')
      @include('const.main-inner')
    @elseif($__env->yieldContent('page_type') == 'outer')
      @include('const.main-outer')
    @endif
    <p id="page-top">
      <a href="#wrap"><i class="fas fa-sort-up"></i></a>
    </p>
    <div class="height-large"></div>
    <div class="footer-push"></div>
  </div>
  @include('const.footer')
</body>
</html>