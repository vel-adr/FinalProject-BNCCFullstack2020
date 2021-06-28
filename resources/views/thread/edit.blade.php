@php
$url = '/thread' . '/' . $thread->id;
@endphp

@extends('layouts.app')

@section('title', 'Edit Thread')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ url($url) }}">
                        @csrf
                        @method('PUT')

                        @php
                        $img = Auth::user()->photo;
                        @endphp

                        <div class="mb-3">
                            <label for="title"><strong>Judul</strong></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                                id="title" placeholder="Isi judul thread" maxlength="45" size="45" required
                                value="{{ $thread->title }}">
                            @error('title')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content"><strong>Konten</strong></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content"
                                id="content" maxlength="255" cols="51" rows="5" placeholder="Isi konten thread"
                                required>{{ $thread->content }}</textarea>
                            @error('content')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <p><strong>Status Thread:</strong></p>
                            <div class="custom-control custom-switch">
                                @if ($thread->status == "open")
                                <input type="checkbox" class="custom-control-input" id="status" name="status"
                                    value="close">
                                @else
                                <input type="checkbox" class="custom-control-input" id="status" name="status"
                                    value="close" checked>
                                @endif
                                <label class="custom-control-label" for="status">Close</label>
                            </div>
                        </div>

                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                        <button type="submit" class="btn btn-success btn-block mt-3">Update</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection