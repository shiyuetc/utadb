@extends('layouts.error')
@section('title', '500 Error')

@section('content')
<div class="height-medium"></div>
@component('components.error')
@slot('title')
  500 ERROR!
@endslot
@slot('text')
  システムがエラーを返しました。
@endslot
@endcomponent
@endsection