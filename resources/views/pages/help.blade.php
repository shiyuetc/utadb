@extends('layouts.app')
@section('title', 'ヘルプ')
@section('page_type', 'inner')

@section('content')
@component('components.question', ['title' => 'このサイトについて'])
@slot('contents')
  Utadbは&nbsp;<a class="default-link" href="https://github.com/shiyuetc" target="_blank">shiyuetc</a>&nbsp;が個人的に1人で開発・運営している持ち歌を記録して人と共有したりできるほぼ自己満足のウェブサイトです。<br>
  元はPHPのフレームワークであるLaravelやJSのフレームワークであるVue.jsの学習用のために立ち上げたプロジェクトの1つで、不具合は多数ありますが最低限動くようになってきたので現在は不定期で更新しています。
@endslot
@endcomponent

@component('components.question', ['title' => '基本的な使い方がわからない'])
@slot('contents')
  <a class="default-link" href={{ route('home') }}>習うより慣れろ</a>
@endslot
@endcomponent

@component('components.question', ['title' => 'ステータスの使い分け方がわからない'])
@slot('contents')
  ステータスには「気になる」、「習得中」、「習得済み」の3つの状態があります。<br>
  「気になる」は気になっている曲、練習しようか迷ってる曲の状態を表します。<br>
  「習得中」は歌詞を覚えている途中、完璧ではないがなんとなく歌えるという状態を表します。<br>
  「習得済み」は歌詞を覚えていて普通に歌うことができる状態を表します。<br>
  これらは完全な定義では無いので参考程度にして細かい部分は自分の中で一定のルールを決めて上手く利用してください。
@endslot
@endcomponent

@component('components.question', ['title' => '登録したい曲が見つからない'])
@slot('contents')
  今現在は<a class="default-link" href="https://www.apple.com/jp/itunes/" target="_blank">iTunes Music</a>または、<a class="default-link" href="https://www.clubdam.com/" target="_blank">DAM CHANNEL</a>で配信されている曲に限定させて頂いております。
@endslot
@endcomponent

@component('components.question', ['title' => 'ローカルからの検索結果とは'])
@slot('contents')
  APIにより取得されるデータには同じアーティストの同じタイトルの曲が複数存在していることがあります、こういった場合他ユーザーと別々の曲を登録しないように以前誰かが登録したことのある曲のみフィルターをかけたものを「ローカルから」という形で表示しています。
@endslot
@endcomponent

@component('components.question', ['title' => 'システムの不具合を発見した'])
@slot('contents')
  当サイト内で不具合を発見された場合は更新を投稿している<a class="default-link" href="https://twitter.com/sakuflip" target="_blank">Twitter</a>にリプライもしくは、Githubの<a class="default-link" href="https://github.com/shiyuetc/utadb/issues" target="_blank">Issues</a>からご連絡頂ければ幸いです。
@endslot
@endcomponent

@component('components.question', ['title' => 'こういう機能が欲しい'])
@slot('contents')
  上記の項目と同一方法でご連絡頂ければ幸いです。メッセージに対して全てお答えはできませんが今後の開発の参考にさせて頂きます。
@endslot
@endcomponent

@component('components.question', ['title' => '退会したい'])
@slot('contents')
  <a class="default-link" href="{{ route('settings.account') }}">アカウントの設定ページ</a>の「アカウントの削除」欄から退会処理を行うことができます。<br>
  退会処理から7日以降に特定のタイミングで完全に消去され、元に戻すことはできなくなってしまいます。
@endslot
@endcomponent
@endsection
