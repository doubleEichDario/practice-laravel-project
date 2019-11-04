@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="row mb-5">
        <div class="col-md-4">
          @if($user -> image)
          <img class="img-thumbnail" src="{{ route('user-avatar', ['filename' => $user-> image]) }}" width="100%" alt="Avatar">
          @endif
        </div>
        <div class="col-md-8">

          <h1>{{ '@'.$user -> nick }}</h1>
          <h2 class="text-muted">{{ $user -> name.' '.$user -> surname}}</h2>
          <h5 class="text-muted">{{ __('Joined'.' '.FormatTime::LongTimeFilter($user -> created_at)) }}</h5>

        </div>
      </div>
          <!-- Posts -->
          <div class="card pub">
              <div class="card-header">
                {{ __('Posts') }}
              </div>
                  @foreach($user -> images as $image)
                  <div class="card-body pub-body">
                <div class="pub-img-container">
                  <a class="pub-link" href="{{ route('image-detail', ['id' => $image -> id]) }}">
                    <img class="pub-img" src="{{ route('post-image', ['filename' => $image -> image_path ]) }}" alt="Image">
                  </a>
                </div>
                <div class="pub-interactions">

                  <!-- Likes -->
                  <!-- Likes counter -->
                  {{ count($image -> likes) }}

                  <!-- Check if authenticated user liked this post -->
                  <?php $user_liked_it = false; ?>
                  @foreach($image -> likes as $like)
                    @if($like -> user -> id == Auth::user() -> id)
                      <?php $user_liked_it = true; ?>
                    @endif
                  @endforeach

                  @if($user_liked_it)
                    <img class="pub-interactions-like" src="{{ asset('img/redheart.png')}}" data-id ="{{ $image -> id }}">
                  @else
                    <img class="pub-interactions-dislike" src="{{ asset('img/grayheart.png')}}" data-id ="{{ $image -> id }}">
                  @endif

                 <!-- Comments -->
                  <div class="pub-comments">
                    <a href="" class="text-black-50 bolder">{{ count($image -> comments).' '.__('comments') }}</a>
                  </div>

                  <span class="float-right pub-interactions-date">{{ \FormatTime::LongTimeFilter($image -> created_at) }}</span>

                </div>

                <div class="pub-description-container">
                  <span class="nick">{{ '@'.$image -> user -> nick}}</span>
                  <p class="pub-description">{{ $image -> description}}</p>
                </div>
              </div>
                @endforeach
          </div>



    </div>
  </div>
</div>
@endsection
