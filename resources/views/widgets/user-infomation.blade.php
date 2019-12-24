<div class="user-infomation section{{ !empty($hidden) ? ' section-hidden' : '' }}">
  <div class="user-profile">
    <div class="avatar-box">
      <a href="{{ route('user', ['id' => $user->screen_name]) }}"><img class="avatar" src="{{ asset('images/profile_image/' . $user->profile_image . '.png') }}" alt="avatar"></a>
    </div>
    <p class="name"><a class="bold underline" href="{{ route('user', ['id' => $user->screen_name]) }}">{{ $user->name }}&nbsp;(&#64;{{ $user->screen_name }})</a></p>
    <p class="description">{{ $user->description }}</p>
    <p class="created"><i class="fa fa-calendar-alt"></i>&nbsp;{{ date('Y年m月d日',  strtotime($user->created_at)) }}に登録&nbsp;({{ (strtotime(date('Y-m-d')) - strtotime(date_format(date_create($user->created_at), 'Y-m-d'))) / 86400 }}日経過)</p>
    <user-accessory-component :user="{{ $user }}" :is_auth="{{ Auth::check() ? 1 : 0}}" :is_me="{{ $user->id == auth()->id() ? 1 : 0 }}"></user-accessory-component>
  </div>
  <ul class="option-list list list-flex">
    <li class="{{ Request::is('@*/records') ? ' active' : '' }}"><a href="{{ route('user.records', ['id' => $user->screen_name]) }}"><span class="hidden-sm-below"><i class="fas fa-book"></i>&nbsp;</span>記録<span class="right-icon status-count">{{ $user->record_count }}件</span></a></li>
    <li class="{{ Request::is('@*/friends') ? ' active' : '' }}"><a href="{{ route('user.friends', ['id' => $user->screen_name]) }}"><span class="hidden-sm-below"><i class="fas fa-user-friends"></i>&nbsp;</span>フレンド<span class="right-icon status-count">{{ $user->following_count }} / {{ $user->follower_count }}人</span></a></li>
    @if(Auth::check() && $user->id != auth()->id())
    <li class="{{ Request::is('@*/common') ? ' active' : '' }}"><a href="{{ route('user.common', ['id' => $user->screen_name]) }}"><span class="hidden-sm-below"><i class="fas fa-link"></i>&nbsp;</span>共通の曲<span class="right-icon status-count">{{ $user->common_count }}曲</span></a></li>
    @endif
  </ul>
  <div class="border"></div>
  <ul class="user-statuses list list-flex">
    <li class="{{ Request::is('@*/status/all') ? ' active' : '' }}"><a href="{{ route('user.status', ['id' => $user->screen_name, 'state' => 'all']) }}"><span class="hidden-sm-below"><i class="fa fa-check"></i>&nbsp;</span>登録済み<span class="hidden-md-below">の曲</span><span class="right-icon status-count">{{ $user->stateCount() }}曲</span></a></li>
    <li class="{{ Request::is('@*/status/mastered') ? ' active' : '' }}"><a href="{{ route('user.status', ['id' => $user->screen_name, 'state' => 'mastered']) }}"><span class="hidden-sm-below"><i class="fa fa-check"></i>&nbsp;</span>習得済み<span class="hidden-md-below">の曲</span><span class="right-icon status-count">{{ $user->mastered_count }}曲</span></a></li>
    <li class="{{ Request::is('@*/status/training') ? ' active' : '' }}"><a href="{{ route('user.status', ['id' => $user->screen_name, 'state' => 'training']) }}"><span class="hidden-sm-below"><i class="fas fa-graduation-cap"></i>&nbsp;</span>練習中<span class="hidden-md-below">の曲</span><span class="right-icon status-count">{{ $user->training_count }}曲</span></a></li>
    <li class="{{ Request::is('@*/status/stacked') ? ' active' : '' }}"><a href="{{ route('user.status', ['id' => $user->screen_name, 'state' => 'stacked']) }}"><span class="hidden-sm-below"><i class="far fa-sticky-note"></i>&nbsp;</span>気になる<span class="hidden-md-below">曲</span><span class="right-icon status-count">{{ $user->stacked_count }}曲</span></a></li>
  </ul>
</div>