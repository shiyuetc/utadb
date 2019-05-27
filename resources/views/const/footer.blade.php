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
@php
  $scripts = [
    'page_top',
    'animation_icon',
    'avatar_button',
  ]
@endphp
@foreach ($scripts as $script)
  @if($__env->yieldContent("js_$script"))
  <script type="text/javascript" src="js/{{ $script }}.js"></script>
  @endif
@endforeach