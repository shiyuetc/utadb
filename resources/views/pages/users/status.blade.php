@extends('layouts.app')
@section('title', "{$user->name}(@{$user->screen_name})さんの{$state['jp']}")

@section('sidebar')
@include('widgets.user-infomation', ['user' => $user])
@endsection

@section('content')
@component('components.section', ['toggle' => true, 'toggleState' => empty($_GET['q'])])
@slot('title')
  <i class="fas fa-filter"></i>&nbsp;曲の絞り込み
@endslot
@slot('contents')
  <form class="form" method="GET" action="#">
    <table class="form-table">
      <tr>
        <td width="100%">
          <input class="text" value="{{ Request::input('q') }}" name="q" placeholder="絞り込みキーワード" maxlength="20" autocomplete="off">
        </td>
        <td nowrap>
          <button class="button button-info const-height" type="submit" name="filter" value="#"><i class="fas fa-filter"></i><span class="hidden-md-below">&nbsp;絞り込み</span></button>
        </td>
        <td nowrap>
        <button class="button button-danger const-height" type="reset" onclick="location.href='{{ url()->current() }}'" {{ empty($_GET['q']) ? 'disabled' : '' }}><i class="fas fa-minus"></i><span class="hidden-md-below">&nbsp;クリア</span></button>
        </td>
      </tr>
    </table>
  </form>
@endslot
@endcomponent

@component('components.section')
@slot('title')
  <i class="{{ $state['icon-class'] }}"></i>&nbsp;{{ $state['jp'] }}
@endslot
@slot('contents')
  <song-user-component :user_id="'{{ $user->id }}'" :state="{{ $state['index'] }}" :page="{{ $page }}" :keyword="'{{ $q }}'"/>
@endslot
@endcomponent
@endsection