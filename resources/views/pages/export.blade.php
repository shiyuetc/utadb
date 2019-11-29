@extends('layouts.app')
@section('title', 'Export')
@section('page_type', 'inner')

@section('content')
<div class="section">
<table class="object-table">
  <thead>
    <tr>
      <th class="left-bring">アーティスト名</th>
      <th class="left-bring">曲名</th>
    </tr>
  </thead>
  <tbody> 
  @foreach($data as $song)
    <tr>
      <td>{{ $song->artist }}</td>
      <td>{{ $song->title }}</td>
    </tr>
  @endforeach
  </tbody>
</table>
</div>
@endsection
