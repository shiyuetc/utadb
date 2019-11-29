<div class="footer">
  <div class="footer-wrapper">
    <div class="external">
      <a href="https://twitter.com/sakuflip" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
      <a href="https://github.com/shiyuetc/utadb" target="_blank" rel="noopener"><i class="fab fa-github"></i></a>
    </div>
    <div class="copyright">
      <p><a class="underline" href="{{ route('terms') }}" target="_blank">利用規約</a> | <a class="underline" href="{{ route('privacy') }}" target="_blank">プライバシーポリシー</a></p>
      <p>Copyright &copy; 2018/05 ~ 2019 shiyuetc</p>
    </div>
  </div>
</div>
@if (app()->isLocal() || app()->runningUnitTests())
  <script src="{{ mix('js/app.js') }}"></script>
@else 
  <script src="./public/js/app.js"></script>
@endif
<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/page_top.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/player.js') }}"></script>
@php
  $scripts = [
    ['avatar_button'],
    ['twitter_widgets', 'https://platform.twitter.com/widgets.js'],
  ]
@endphp
@foreach ($scripts as $script)
  @if($__env->yieldContent("js_$script[0]"))
    @if(count($script) == 1)
      <script type="text/javascript" src="{{ asset('js/'.$script[0].'.js') }}"></script>
    @else
      <script async type="text/javascript" src="{{ $script[1] }}"></script>
    @endif
  @endif
@endforeach