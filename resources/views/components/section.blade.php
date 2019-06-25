<div class="section{{ isset($hidden) && $hidden ? ' section-hidden' : '' }}{{ isset($padding) && $padding ? ' section-padding' : '' }}">
  @isset($title)
    <div class="header">
      <h1 class="title">{{ $title }}</h1>
      @if(isset($toggle) && $toggle)
        <span class="section-toggle{{ isset($toggleState) && $toggleState ? ' hidden' : '' }}" onclick="toggleSection(this)"><i class="fas fa-chevron-up"></i></span>
      @endif
    </div>
  @endisset
  <div class="contents" style="{{ isset($toggleState) && $toggleState ? 'display: none;' : '' }}">
    {{ $contents }}
  </div>
</div>