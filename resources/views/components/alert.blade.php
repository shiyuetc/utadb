@if ($errors->any())
@foreach ($errors->all() as $error)
<div class="message message-danger">
  <p class="text">{{ $error }}</p>
  <button type="button" class="close-button" aria-label="close"></button>
</div>
@break
@endforeach
@elseif(isset($alert))
<div class="message message-{{ $alert['type'] }}">
  <p class="text">{{ $alert['text'] }}</p>
  <button type="button" class="close-button" aria-label="close"></button>
</div>
@endif