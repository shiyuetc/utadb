@component('components.section', ['toggle' => true])
@slot('title')
  <i class="fas fa-tools"></i>&nbsp;ツール
@endslot
@slot('contents')
  <ul class="list list-angle">
    <li class="{{ Request::is('tools/export') ? ' active' : '' }}"><a href="{{ route('tools.export') }}"><i class="fas fa-cloud-download-alt"></i>&nbsp;エクスポート<span class="right-icon"><i class="fas fa-angle-double-right"></i></span></a></li>
  </ul>
@endslot
@endcomponent