@if(Auth::user() -> image)
  <img class="avatar-image rounded-circle" src="{{ url('/user/avatar/'.Auth::user() -> image) }}" width="40px" alt="Avatar">
@endif
