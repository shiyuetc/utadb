@extends('layouts.error')

@section('content')
<div class="height-medium"></div>
@component('components.error', ['visible_fallback' => true])
@slot('title')
  403 ERROR!
@endslot
@slot('text')
  このページを閲覧する権限がありません。
@endslot
@endcomponent
@endsection