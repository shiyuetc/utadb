<div class="introduct section animated fadeIn" style="animation-delay: {{ $delay_time }}s;">
  <div class="description">
    <h2 class="title">{{ $title }}</h2>
    <p class="text">{{ $text }}</p>
    @if(!empty($subtext))
    <p class="text text-small">{{ $subtext }}</p>
    @endif
  </div>
  <div class="capture">
    <img src="images/captures/{{ $capture_image }}" alt="capture">
  </div>
</div>