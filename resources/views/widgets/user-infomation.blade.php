<div class="user-infomation section{{ (isset($hide) && $hide) ? ' section-hide' : '' }}">
  <div class="user-profile">
    <div class="avatar-box">
      <a href="{{ route('user', ['id' => $user->screen_name]) }}"><img id="avatar" src="{{ asset('images/sample_avatar.png') }}" alt="avatar"></a>
    </div>
    <p class="name"><a class="default-link" href="{{ route('user', ['id' => $user->screen_name]) }}">{{ $user->name }}&nbsp;(&#64;{{ $user->screen_name }})</a></p>
    <p class="description">{{ $user->description }}</p>
    <p class="created"><i class="fa fa-calendar-alt"></i>&nbsp;{{ date('Y年m月d日',  strtotime($user->created_at)) }}に登録&nbsp;({{ (strtotime(date('Y-m-d')) - strtotime(date_format(date_create($user->created_at), 'Y-m-d'))) / 86400 }}日経過)</p>
  </div>
  <ul class="user-statuses">
    <li class="{{ Request::is('@*/status/all') ? ' active' : '' }}"><a href="{{ route('user.status', ['id' => $user->screen_name, 'state' => 'all']) }}"><i class="fa fa-check"></i>&nbsp;登録済みの曲<span class="status-count">{{ $user->allStateCount() }}曲</span></a></li>
    <li class="{{ Request::is('@*/status/mastered') ? ' active' : '' }}"><a href="{{ route('user.status', ['id' => $user->screen_name, 'state' => 'mastered']) }}"><i class="fa fa-check"></i>&nbsp;習得済みの曲<span class="status-count">{{ $user->mastered_state_count }}曲</span></a></li>
    <li class="{{ Request::is('@*/status/training') ? ' active' : '' }}"><a href="{{ route('user.status', ['id' => $user->screen_name, 'state' => 'training']) }}"><i class="fas fa-graduation-cap"></i>&nbsp;練習中の曲<span class="status-count">{{ $user->training_state_count }}曲</span></a></li>
    <li class="{{ Request::is('@*/status/stacked') ? ' active' : '' }}"><a href="{{ route('user.status', ['id' => $user->screen_name, 'state' => 'stacked']) }}"><i class="far fa-sticky-note"></i>&nbsp;気になる曲<span class="status-count">{{ $user->stacked_state_count }}曲</span></a></li>
  </ul>
</div>