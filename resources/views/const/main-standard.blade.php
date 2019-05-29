@php
if ($errors->any()) {
  foreach ($errors->all() as $error) {
    $alert = ['type' => 'danger', 'text' => $error];
    break;
  }
}
@endphp
<div class="main main-inner">
  <div class="margin-const">
    @if(isset($alert))
      @include('components.alert', ['type' => $alert['type'], 'text' => $alert['text']])
    @endif
    <div class="sidebar">
      @yield('sidebar')
    </div>
    <div class="content">
      @yield('content')
    </div>
  </div>
</div>