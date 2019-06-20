@component('components.section', ['hidden' => true, 'padding' => true])
  @slot('contents')
    <button class="button button-danger" onclick="location='{{ route('register') }}'">新規登録</button>
    <p class="f12 center">もしくは</p>
    <button class="button button-danger" onclick="location='{{ route('login') }}'">ログイン</button>
  @endslot
@endcomponent