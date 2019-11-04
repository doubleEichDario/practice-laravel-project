
@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <form action="{{ route('user-index') }}" method="get" id="people-searcher">


        <div class="form-group">
          <input id="search" class="form-control" type="text">
          <input class="btn btn-primary search-button" type="submit" value="Buscar">
        </div>

      </form>
      @foreach($users as $user)
        <div class="row mb-5">
          <div class="col-md-4">
            @if($user -> image)
              <img class="img-thumbnail" src="{{ route('user-avatar', ['filename' => $user -> image]) }}" width="100%" alt="Avatar">
            @endif
          </div>
          <div class="col-md-8">
            <a href="{{ route('user-profile', ['id' => $user -> id]) }}">
              <h1>{{ '@'.$user -> nick }}</h1>
            </a>
            <h2 class="text-muted">{{ $user -> name.' '.$user -> surname}}</h2>
            <h5 class="text-muted">{{ __('Joined'.' '.FormatTime::LongTimeFilter($user -> created_at)) }}</h5>

          </div>
        </div>
      @endforeach

      <!-- Pagination -->
      <div class="text-center">
        {{ $users -> links() }}
      </div>

    </div>
  </div>
</div>
@endsection
