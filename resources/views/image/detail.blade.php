@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
          @include('includes.message')
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

                  <div class="pub-img-container on-detail">
                    <img class="pub-img" src="{{ route('post-image', ['filename' => $image -> image_path ]) }}" alt="Image">
                  </div>

                  <div class="pub-interactions">

                    <span class="float-right pub-interactions-date">{{ \FormatTime::LongTimeFilter($image -> created_at) }}</span>
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

                    @if(Auth::user() -> id == $image -> user -> id)
                      <div class="pub-interactions-image-actions">
                        <a class="btn btn-sm btn-primary" href="{{ route('edit-image', ['id' => $image -> id]) }}">
                          {{ __('Edit') }}
                        </a>


                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal">
                          {{ __('Delete') }}
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Delete Post')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                {{ __('You sure?')}}
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                <a class="btn btn-danger" href="{{ route('delete-image', ['id' => $image -> id])}}">
                                  {{ __('Yes, definetely delete it') }}
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>


                      </div>
                    @endif

                  </div>


                  <div class="pub-description-container">
                    <span class="nick">{{ '@'.$image -> user -> nick}}</span>
                    <p class="pub-description">{{ $image -> description}}</p>
                  </div>

                  <div class="pub-comments on-detail">

                    <h5 class="text-black-50 bolder">{{ count($image -> comments).' '.__('comments') }}</h5>
                    <hr>
                    <form action="{{ route('save-comment')}}" method="POST">
                      @csrf
                      <input type="hidden" name="image_id" value="{{ $image -> id}}">

                      <p>
                        <textarea class="form-control {{ $errors -> has('content') ? 'is-invalid' : '' }}"  name="content"></textarea>
                        @if ($errors->has('content'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ __('Fill input to save your comment')}}</strong>
                            </span>
                        @endif
                      </p>
                      <button class="btn btn-primary" type="submit" name="button">{{ __('Save') }}</button>
                    </form>
                    @foreach($image -> comments as $comment)
                      <div class="pub-comments-item">

                        <span class="float-right pub-date">{{ \FormatTime::LongTimeFilter($comment -> created_at) }}</span>
                        @if($comment -> user -> image)
                          <img class="avatar-image rounded-circle" src="{{ route('user-avatar', ['filename' => $comment -> user -> image]) }}" width="35px" alt="Avatar">
                        @endif
                        <span class="nick">{{ '@'.$comment -> user -> nick}}</span>
                        <p class="pub-comments-item-content">{{ $comment -> content}}</p>
                        @if(Auth::check() && ($comment -> user_id == Auth::user() -> id || $comment -> image -> user_id == Auth::user() -> id))
                          <a class="pub-comments-item-delete" href="{{ route('delete-comment', ['id' => $comment -> id]) }}">{{ __('Delete') }}</a>
                        @endif
                      </div>
                    @endforeach

                  </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
