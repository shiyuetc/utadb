<div class="error">
  <h1 class="title">{{ $title }}</h1>
  <p class="text">{{ $text }}</p>
  @if($visible_fallback)
  <p class="fallback"><a class="default-link" href="{{ route('home') }}">トップに戻る</a></p>
  @endif
</div>