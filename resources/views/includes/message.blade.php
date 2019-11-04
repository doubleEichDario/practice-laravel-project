@if(session('message'))
    <div class="alert alert-success" role="alert">
      {{ __(session('message')) }}
    </div>
@endif
