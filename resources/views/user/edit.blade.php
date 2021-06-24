@extends('layouts.app')

@section('title', 'Edit your profile')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Update your profile</h3>
        </div>
        <div class="card-body">
            <form action="/user/{id}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ $user->email }}" required autocomplete="email"
                            value="{{ $user->email }}">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('Profile Photo') }}</label>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col">
                                <img src="{{ url('/img/' . $user->photo) }}" alt="Photo Profile"
                                    style="width: 100px; height: 100px; border-radius:50%">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <input id="photo" type="file"
                                    class="form-control-file @error('photo') is-invalid @enderror" name="photo">
                            </div>
                        </div>


                        @error('photo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection