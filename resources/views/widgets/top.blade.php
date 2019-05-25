<div class="top">
  <div class="banner inner-padding">
    <img id="icon" src="images/icons/icon-48x.png" alt="icon">
    <h1 class="title">Utad<span style="opacity: 0.6;">ata</span>b<span style="opacity: 0.6;">ase</span></h1>
    <p class="text">Utadb は自分の持ち歌（歌える曲）や気になった曲を記録して管理したりユーザー同士で共有ができるWebサービスです。<br>カラオケ等へ行くとき用にメモ感覚で簡単に使えます。</p>
  </div>
  <div class="prompt">
    <button class="button button-danger auto" onclick="location.href='{{ route('register') }}'">今すぐ曲の管理を始める</button>
  </div>
  <div class="introducts inner-margin">
    <div class="introduct animated fadeIn" style="animation-delay: 0.2s;">
      <div class="description">
        <h2 class="title">分かりやすい持ち曲の管理</h2>
        <p class="text">曲の状態をメモ記録、習得中、習得済みの3つに振り分けて現在の状態を一目できます。</p>
        <p class="text text-small">※分け方の目安<br>
          メモ記録 : 気になっている又は、習得する予定の曲等<br>
          習得中　 : 練習中や、歌詞を覚えている途中の曲等<br>
          習得済み : 既に習得していて最後まで歌える状態の曲等</p>
      </div>
      <div class="capture">
        <img src="images/captures/training.jpg" alt="capture">
      </div>
    </div>
    <div class="introduct animated fadeIn" style="animation-delay: 1.2s;">
      <div class="description">
        <h2 class="title">シンプルなタイムライン機能</h2>
        <p class="text">自分もしくは他のユーザーの更新をリスト形式で表示され、このページからサンプル音源の視聴や状態の更新を行うことが出来ます。</p>
        <p class="text text-small">※曲はiTunes及びDAMで配信されている項目を取得できます。</p>
      </div>
      <div class="capture">
        <img src="images/captures/timeline.jpg" alt="capture">
      </div>
    </div>
    <div class="introduct animated fadeIn" style="animation-delay: 2.2s;">
      <div class="description">
        <h2 class="title">他のユーザーとの共有</h2>
        <p class="text">他のユーザーがそれぞれの状態に登録している曲やお互いに習得済みに登録している曲のリストを確認できます。</p>
        <p class="text text-small">※この項目に関しては今後のアップデートで徐々に追加していく予定です。</p>
      </div>
      <div class="capture">
        <img src="images/captures/users.jpg" alt="capture">
      </div>
    </div>
  </div>
  <div class="prompt">
    <button class="button button-danger auto" onclick="location.href='{{ route('register') }}'">今すぐ曲の管理を始める</button>
  </div>
</div>