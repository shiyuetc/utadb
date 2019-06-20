<div class="section{{ isset($hidden) && $hidden ? ' section-hidden' : '' }}{{ isset($padding) && $padding ? ' section-padding' : '' }}">
  @isset($title)
    <div class="header">
      <h1 class="title">{{ $title }}</h1>
    </div>
  @endisset
  <div class="contents">
    {{ $contents }}
  </div>
</div>