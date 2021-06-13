@php
$imgName = $ts->photo;
@endphp

@extends('layouts.app')

@section('title', '{{ $thread->title }}')

@section('content')
<div class="container">
    <div class="row thread-content">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between">
                        <div class="col d-flex align-items-center">
                            <img src="{{ url('/img/' . $imgName) }}" alt=""
                                style="width: 40px; height: 40px; border-radius:50%">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <div>{{ $ts->name }}</div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div>{{ $thread->created_at }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (Auth::id() == $thread->user_id)
                        <div class="col-sm-2">
                            <a href="/thread/{{ $thread->id }}/edit" class="btn btn-outline-success">Edit Thread</a>
                        </div>
                        @endif
                    </div>
                </div>


                <div class="card-body">
                    <h4 class="card-title">{{ $thread->title }}</h4>
                    <p class="card-text">{{ $thread->content }}</p>
                </div>


                <div class="card-footer">
                    <button class="btn btn-outline-info btn-sm" type="button" data-toggle="collapse"
                        data-target="#collapse-exp" aria-expanded="false" aria-controls="collapse-exp">
                        Comment
                    </button>
                    <div class="collapse mt-3" id="collapse-exp">
                        <form method="POST" action="{{ route('comment.create') }}">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control @error('comment') is-invalid @enderror" name="comment"
                                    id="comment" maxlength="255" cols="51" rows="3"
                                    placeholder="Write your comment here" required></textarea>
                                @error('comment')
                                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- sementara profileid selalu 1 karena belum ada login --}}
                            <input type="hidden" name="user_id" value="1">
                            <input type="hidden" name="thread_id" value="{{ $thread->id }}">

                            <button type="submit" class="btn btn-outline-success">Submit</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="thread-comments mt-3 ">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    @foreach ($comments as $c)
                    <div class="media px-4 py-4 my-3 border-top border-bottom bg-light">

                        <div class="user mr-3">
                            <img src="{{ url('/img/' . $imgName) }}" alt="..."
                                style="width: 40px; height: 40px; border-radius:50%">
                            <p><strong>{{ $c->user->name }}</strong></p>
                            <p>{{ date_format($c->updated_at, 'd-m-Y') }}</p>
                            <p>{{ date_format($c->updated_at, 'H:i') }}</p>
                        </div>

                        <div class="col media-body">
                            <p class="mt-2">{{ $c->comment }}</p>
                            <button class="btn btn-outline-info btn-sm" type="button" data-toggle="collapse"
                                data-target="#commentcollapse{{ $c->id }}" aria-expanded="false"
                                aria-controls="commentcollapse{{ $c->id }}">
                                Reply
                            </button>
                            <div class="collapse mt-3" id="commentcollapse{{ $c->id }}">
                                <form method="POST" action="{{ route('reply.create') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea class="form-control @error('reply') is-invalid @enderror" name="reply"
                                            id="comment-{{ $c->id }}" maxlength="255" cols="51" rows="3"
                                            placeholder="Write your comment here" required></textarea>
                                        @error('reply')
                                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- sementara profileid selalu 1 karena belum ada login --}}
                                    <input type="hidden" name="user_id" value="1">
                                    <input type="hidden" name="comment_id" value="{{ $c->id }}">
                                    <input type="hidden" name="thread_id" value="{{ $thread->id }}">

                                    <button type="submit" class="btn btn-outline-success">Submit</button>
                                </form>
                            </div>

                            @if ($c->replies != null)
                            @foreach ($c->replies as $rep)
                            <div class="media mt-4 py-4 px-4 border">
                                <div class="user mr-3">
                                    <img src="{{ url('/img/' . $imgName) }}" alt="..."
                                        style="width: 40px; height: 40px; border-radius:50%">
                                    <p><strong>{{ $rep->user->name }}</strong></p>
                                </div>
                                <div class="col media-body">
                                    <p class="mt-2">{{ $rep->reply }}</p>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endsection