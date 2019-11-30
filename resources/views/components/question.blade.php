@component('components.section', ['toggle' => true, 'toggleState' => true, 'padding' => true])
@slot('title')
  <i class="fas fa-question-circle"></i>&nbsp;{{ $title }}
@endslot
@slot('contents')
  {{ $contents }}
@endslot
@endcomponent
