@extends('layouts.app')
@section('page_type', 'outer')

@section('content')
<div class="banner">
  <img id="icon" class="animated rotateIn" src="{{ asset('images/icons/icon-48x.png') }}" alt="icon">
  <h1 class="title">Utad<span style="opacity: 0.6;">ata</span>b<span style="opacity: 0.6;">ase</span></h1>
  <p class="text">Utadb は自分の持ち歌（歌える曲）や気になった曲を記録して管理したりユーザー同士で共有ができるWebサービスです。<br>カラオケ等へ行くとき用にメモ感覚で簡単に使えます。</p>
  <resource-counter-component></resource-counter-component>
  <div class="prompt">
    <button class="button button-danger auto" onclick="location.href='{{ route('register') }}'">今すぐ曲の管理を始める</button>
  </div>
</div>
<div class="introducts margin">
  @component('components.introduct', ['delay_time' => '0.2', 'thumbnail' => 'training.jpg'])
    @slot('title')
      シンプルな持ち曲の管理システム
    @endslot
    @slot('text')
      iTunesもしくはDAM CHANNELで配信されている曲の中からお好みで「気になる」、「習得中」、「習得済み」の3つの状態に振り分けて現在の状態を管理できます。<br>
    振り分けた曲は状態ごとに一覧で閲覧でき、いつでも任意の状態に変更可能です。<br>
    また、キーワードにマッチした曲のみを抽出して表示することもできます。
    @endslot
  @endcomponent
  @component('components.introduct', ['delay_time' => '1.2', 'thumbnail' => 'timeline.jpg'])
    @slot('title')
      みんなの更新が見れるタイムライン機能
    @endslot
    @slot('text')
      自分もしくは他のユーザーの更新をリスト形式で表示され、このページからサンプル音源の視聴や状態の更新を行うことが出来ます。
    @endslot
    @slot('subtext')
      ※現時点で曲はiTunes及びDAMで配信されている項目を取得できます。
    @endslot
  @endcomponent
  @component('components.introduct', ['delay_time' => '2.2', 'thumbnail' => 'analysis.jpg'])
    @slot('title')
      登録曲の傾向や利用頻度を自動で分析
    @endslot
    @slot('text')
      登録されたデータを元に、どのようなアーティストの曲を多く登録しているか等、月毎の利用頻度を見やすいチャートで可視化できます。
    @endslot
  @endcomponent
</div>
<div class="height-small"></div>
@endsection