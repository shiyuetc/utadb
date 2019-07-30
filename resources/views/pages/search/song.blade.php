@extends('layouts.app')
@section('title', "曲の検索")

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
@endsection

@section('content')
@component('components.section', ['toggle' => true])
@slot('title')
  <i class="fas fa-music"></i>&nbsp;曲の検索
@endslot
@slot('contents')
  <form class="form" method="GET" action="{{ route('search.song') }}">
    <table class="form-table">
      <tr>
        <td>
          <select class="select" name="source">
            <option value="0">iTunesから検索</option>
            <option value="1" {{ Request::input('source') == 1 ? ' selected' : '' }}>DAMから検索</option>
          </select>
        </td>
        <td width="100%">
          <input class="text" value="{{ Request::input('q') }}" name="q" placeholder="検索キーワード" maxlength="20" autocomplete="off" required>
        </td>
        <td nowrap>
          <button class="button button-info const-height"><i class="fa fa-search"></i><span class="hidden-md-below">&nbsp;検索</span></button>
        </td>
      </tr>
    </table>
    <p class="note">※重複した曲の登録を防ぐために検索後、『ローカルからの検索結果』から優先的に利用することをお勧めします。</p>
  </form>
@endslot
@endcomponent

@if(empty($q))
  @component('components.section', ['toggle' => true])
  @slot('title')
    <i class="fas fa-crown"></i>&nbsp;ランキング曲
  @endslot
  @slot('contents')
    <song-ranking-component />
  @endslot
  @endcomponent
@else
  @component('components.section', ['toggle' => true])
  @slot('title')
    <i class="fa fa-search"></i>&nbsp;ローカルからの検索結果
  @endslot
  @slot('contents')
    <song-search-component :keyword="'{{ $q }}'" :perPage="10" />
  @endslot
  @endcomponent

  @component('components.section')
  @slot('title')
    <i class="fa fa-search"></i>&nbsp;{{ $source == 0 ? 'iTunes' : 'DAM' }}からの検索結果
  @endslot
  @slot('contents')
    <song-search-component :source="{{ $source }}" :keyword="'{{ $q }}'" :page="{{ $page }}" />
  @endslot
  @endcomponent
@endif
@endsection