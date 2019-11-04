@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          @include('includes.message')
          @foreach($images as $image)
            <div class="card pub">
                <div class="card-header">
                  <a class="pub-link" href="{{ route('user-profile', ['id' => $image -> user -> id]) }}">

                    @if($image -> user -> image)
                    <img class="avatar-image rounded-circle" src="{{ route('user-avatar', ['filename' => $image -> user-> image]) }}" width="35px" alt="Avatar">
                    @endif
                    {{ $image -> user -> name.' '.$image -> user -> surname }}
                    <span class="nick">
                      {{ '@'.$image -> user -> nick }}
                    </span>

                  </a>
                </div>
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
            </div>
          @endforeach
          <!-- Pagination -->
          <div class="text-center">
            {{ $images -> links() }}
          </div>

        </div>
    </div>
</div>
@endsection
