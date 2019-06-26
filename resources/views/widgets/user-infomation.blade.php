<div class="user-infomation section{{ !empty($hidden) ? ' section-hidden' : '' }}">
  <div class="user-profile">
    <div class="avatar-box">
      <a href="{{ route('user', ['id' => $user->screen_name]) }}"><img class="avatar" src="{{ $user->profile_image_url }}.png" alt="avatar"></a>
    </div>
    <p class="name"><a class="default-link" href="{{ route('user', ['id' => $user->screen_name]) }}">{{ $user->name }}&nbsp;(&#64;{{ $user->screen_name }})</a></p>
    <p class="description">{{ $user->description }}</p>
    <p class="created"><i class="fa fa-calendar-alt"></i>&nbsp;{{ date('Y年m月d日',  strtotime($user->created_at)) }}に登録&nbsp;({{ (strtotime(date('Y-m-d')) - strtotime(date_format(date_create($user->created_at), 'Y-m-d'))) / 86400 }}日経過)</p>
    <div class="event-buttons">
      @if($user->id == auth()->id())
        <div><button class="button button-default" onclick="location='{{ route('settings.account') }}'">プロフィールの編集</button></div>
      @endif
      <div><button class="button button-default" onclick="location='{{ route('user.random', ['id' => $user->screen_name]) }}'">ランダム選曲</button></div>
    </div>
  </div>
  @if(Auth::check() && $user->id != auth()->id())
  <ul class="option-list list list-flex">
    <li class="{{ Request::is('@*/common') ? ' active' : '' }}"><a href="{{ route('user.common', ['id' => $user->screen_name]) }}"><i class="fas fa-link"></i>&nbsp;共通の曲</a></li>
  </ul>
  <div class="border"></div>
  @endif
  <ul class="user-statuses list list-flex">
    <li class="{{ Request::is('@*/status/all') ? ' active' : '' }}"><a href="{{ route('user.status', ['id' => $user->screen_name, 'state' => 'all']) }}"><span class="hidden-sm-below"><i class="fa fa-check"></i>&nbsp;</span>登録済み<span class="hidden-md-below">の曲</span><span class="right-icon status-count">{{ $user->allStateCount() }}曲</span></a></li>
    <li class="{{ Request::is('@*/status/mastered') ? ' active' : '' }}"><a href="{{ route('user.status', ['id' => $user->screen_name, 'state' => 'mastered']) }}"><span class="hidden-sm-below"><i class="fa fa-check"></i>&nbsp;</span>習得済み<span class="hidden-md-below">の曲</span><span class="right-icon status-count">{{ $user->mastered_count }}曲</span></a></li>
    <li class="{{ Request::is('@*/status/training') ? ' active' : '' }}"><a href="{{ route('user.status', ['id' => $user->screen_name, 'state' => 'training']) }}"><span class="hidden-sm-below"><i class="fas fa-graduation-cap"></i>&nbsp;</span>練習中<span class="hidden-md-below">の曲</span><span class="right-icon status-count">{{ $user->training_count }}曲</span></a></li>
    <li class="{{ Request::is('@*/status/stacked') ? ' active' : '' }}"><a href="{{ route('user.status', ['id' => $user->screen_name, 'state' => 'stacked']) }}"><span class="hidden-sm-below"><i class="far fa-sticky-note"></i>&nbsp;</span>気になる<span class="hidden-md-below">曲</span><span class="right-icon status-count">{{ $user->stacked_count }}曲</span></a></li>
  </ul>
</div>