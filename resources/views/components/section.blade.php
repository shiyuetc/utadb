<div class="section{{ !empty($hidden) ? ' section-hidden' : '' }}{{ !empty($padding) ? ' section-padding' : '' }}">
  @isset($title)
<div class="header">
      <h1 class="title">{{ $title }}</h1>
      @if(!empty($toggle))
        <span class="section-toggle{{ !empty($toggleState) ? ' hidden' : '' }}" onclick="toggleSection(this)"><i class="fas fa-chevron-up"></i></span>
      @endif
    </div>
  @endisset
  <div class="contents" style="{{ !empty($toggleState) ? 'display: none;' : '' }}">
    {{ $contents }}
  </div>
</div>