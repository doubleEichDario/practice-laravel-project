@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">

            <div class="card-header">{{ __('Upload photo')}}</div>

            <div class="card-body">
              <form action="{{ route('save-image') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                  <label for="image_path" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>
                  <div class="col-md-6">
                    <input id="image_path" type="file" name="image_path" class="float-right">
                    @if($errors -> has('image_path'))
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors -> first('image_path')}}</strong>
                      </span>
                    @endif
                  </div>
                </div>

                <div class="form-group row">
                  <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description')}}</label>
                  <div class="col-md-6">
                    <textarea id="description" type="text" name="description" class="form-control float-right" required></textarea>
                    @if($errors -> has('description'))
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors -> first('description') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-6 offset-md-4">
                    <button class="btn btn-primary" type="submit">
                      {{ __('Upload')}}
                    </button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
