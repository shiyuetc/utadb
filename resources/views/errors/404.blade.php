@extends('layouts.error')

@section('content')
<div class="height-medium"></div>
@component('components.error', ['visible_fallback' => true])
@slot('title')
  404 ERROR!
@endslot
@slot('text')
  お探しのページは見つかりませんでした。
@endslot
@endcomponent
@endsection