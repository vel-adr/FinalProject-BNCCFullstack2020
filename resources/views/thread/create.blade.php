@extends('layouts.app')

@section('title', 'Create new thread')

@section('content')
<div class="container">
    <div class="row justify-content-md-center mt-3">
        <div class="col-md-8">
            <form method="POST" action="{{ url('/thread') }}">
                @csrf

                @php
                $img = Auth::user()->photo;
                @endphp

                <ul class="list-group list-group-flush border">
                    <li class="list-group-item">
                        <img src="{{ url('/img/' . $img) }}" style="width: 40px; height:40px; border-radius:50%; object-fit: cover;"
                            class="float-left mr-3">
                        <div class="d-flex align-items-center">
                            <p style="font-size: 1.2em">&nbsp;<a
                                    href="/user/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a>&nbsp;</p>
                            <p class="text-secondary">
                                <small>{{ date('H:i') }}</small></p>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                            id="title" placeholder="Isi judul thread" maxlength="45" size="45" required
                            style="border: none;">
                        @error('title')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="list-group-item">
                        <textarea class="form-control @error('content') is-invalid @enderror" name="content"
                            id="content" maxlength="255" cols="51" rows="5" placeholder="Isi konten thread" required
                            style="border: none;"></textarea>
                        @error('content')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </li>
                </ul>

                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="status" value="open">

                <button type="submit" class="btn btn-primary btn-block mt-3">Post</button>
            </form>
        </div>
    </div>
</div>

@endsection