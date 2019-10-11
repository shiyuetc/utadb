@component('components.section', ['hidden' => true, 'toggle' => true])
@slot('title')
  <i class="fas fa-link"></i>&nbsp;外部関連リンク
@endslot
@slot('contents')
  <ul class="list">
    <li><a class="default-link" href="https://www.joysound.com/web/" target="_blank">JOYSOUND.com</a></li>
    <li><a class="default-link" href="https://www.clubdam.com/" target="_blank">DAM CHANNEL</a></li>
  </ul>
@endslot
@endcomponent