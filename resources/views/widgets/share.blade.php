@section('js_facebook_share', true)
@section('js_twitter_share', true)
@component('components.section', ['hidden' => true, 'toggle' => true, 'padding' => true])
@slot('title')
  <i class="fas fa-share-alt"></i>&nbsp;シェア
@endslot
@slot('contents')
<div>
  <div class="button-share">
    <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false"></a>
  </div>
  <div class="fb-share-button button-share" data-href="{{ url()->current() }}" data-layout="button_count" data-size="small">
    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"></a>
  </div>
</div>
@endslot
@endcomponent
