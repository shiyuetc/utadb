<div class="footer">
  <div class="footer-wrapper">
    <div class="external">
      <a href="https://twitter.com/sakuflip" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
      <a href="https://github.com/shiyuetc/utadb" target="_blank" rel="noopener"><i class="fab fa-github"></i></a>
    </div>
    <div class="copyright">
      <p>Copyright &copy; 2018/05 ~ 2019 shiyu</p>
    </div>
  </div>
</div>
<script src="{{ mix('js/app.js') }}"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/player.js"></script>
<script>

</script>
@php
  $scripts = [
    ['page_top'],
    ['animation_icon'],
    ['avatar_button'],
    ['twitter_widgets', 'https://platform.twitter.com/widgets.js'],
  ]
@endphp
@foreach ($scripts as $script)
  @if($__env->yieldContent("js_$script[0]"))
    @if(count($script) == 1)
      <script type="text/javascript" src="js/{{ $script[0] }}.js"></script>
    @else
      <script async type="text/javascript" src="{{ $script[1] }}"></script>
    @endif
  @endif
@endforeach