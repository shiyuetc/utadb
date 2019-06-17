@extends('layouts.app')
@section('page_type', 'outer')

@section('content')
<div class="banner padding-const">
  <img id="icon" class="animated rotateIn" src="{{ asset('images/icons/icon-48x.png') }}" alt="icon">
  <h1 class="title">Utad<span style="opacity: 0.6;">ata</span>b<span style="opacity: 0.6;">ase</span></h1>
  <p class="text">Utadb は自分の持ち歌（歌える曲）や気になった曲を記録して管理したりユーザー同士で共有ができるWebサービスです。<br>カラオケ等へ行くとき用にメモ感覚で簡単に使えます。</p>
</div>
<div class="prompt">
  <button class="button button-danger auto" onclick="location.href='{{ route('register') }}'">今すぐ曲の管理を始める</button>
</div>
<div class="introducts margin-const">
  @component('components.introduct', ['delay_time' => '0.2', 'capture_image' => 'training.jpg'])
    @slot('title')
      シンプルな持ち曲の管理システム
    @endslot
    @slot('text')
      曲の状態を気になる、習得中、習得済みの3つに振り分けて現在の状態を一目できます。
    @endslot
    @slot('subtext')
      ※分け方の目安<br>
      習得済み : 既に習得していて最後まで歌える状態の曲等<br>
      練習中　 : 練習中や、歌詞を覚えている途中の曲等<br>
      気になる曲 : 気になっている又は、習得する予定の曲等
    @endslot
  @endcomponent
  @component('components.introduct', ['delay_time' => '1.2', 'capture_image' => 'timeline.jpg'])
    @slot('title')
      みんなの更新が見れるタイムライン機能
    @endslot
    @slot('text')
      自分もしくは他のユーザーの更新をリスト形式で表示され、このページからサンプル音源の視聴や状態の更新を行うことが出来ます。
    @endslot
    @slot('subtext')
      ※曲はiTunes及びDAMで配信されている項目を取得できます。
    @endslot
  @endcomponent
  @component('components.introduct', ['delay_time' => '2.2', 'capture_image' => 'users.jpg'])
    @slot('title')
      他のユーザーとの情報共有
    @endslot
    @slot('text')
      他のユーザーがそれぞれの状態に登録している曲やお互いに習得済みに登録している曲のリストを確認できます。
    @endslot
    @slot('subtext')
      ※この項目に関しては今後のアップデートで徐々に追加していく予定です。
    @endslot
  @endcomponent
</div>
<div class="height-small"></div>
@endsection