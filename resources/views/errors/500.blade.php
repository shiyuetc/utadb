@extends('layouts.error')

@section('content')
<div class="height-medium"></div>
@component('components.error', ['visible_fallback' => false])
@slot('title')
  500 ERROR!
@endslot
@slot('text')
  システムがエラーを返しました。
@endslot
@endcomponent
@endsection