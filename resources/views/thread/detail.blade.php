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
                    <h4 class="card-title"><strong>{{ $thread->title }}</strong></h4>
                    <p class="card-text">{{ $thread->content }}</p>
                </div>


                <div class="card-footer">
                    <button class="btn btn-outline-info btn-sm" type="button" data-toggle="collapse"
                        data-target="#collapse-comment @if(Auth::id() == null){{ '-invalid' }}@endif"
                        aria-expanded="false" aria-controls="collapse-comment">
                        Comment
                    </button>
                    <div class="collapse mt-3" id="collapse-comment">
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

                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" name="thread_id" value="{{ $thread->id }}">

                            <button type="submit" class="btn btn-outline-success">Submit</button>
                        </form>
                    </div>
                    <div class="collapse mt-3" id="collapse-comment-invalid">
                        <div class="alert alert-danger mt-3" role="alert">
                            You must log in to comment!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @error('user_id')
    <div class="alert alert-danger alert-dismissible mt-3 fade show" role="alert">
        You must log in to comment!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @enderror

    <div class="thread-comments mt-3">
        @foreach ($comments as $c)
        <div class="card my-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="media px-4 py-4 my-3">
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
                                data-target="#collapse-comment-{{ $c->id }}@if(Auth::id()==null){{ "-invalid" }}@endif"
                                aria-expanded="false" aria-controls="collapse-comment-{{ $c->id }}">
                                Reply
                            </button>
                            @if ($c->user_id == Auth::id())
                            <button class="btn btn-outline-info btn-sm" type="button" data-toggle="collapse"
                                data-target="#collapse-comment-{{ $c->id }}-edit" aria-expanded="false"
                                aria-controls="collapse-comment-{{ $c->id }}">
                                Edit
                            </button>
                            @endif
                            <div class="collapse mt-3" id="collapse-comment-{{ $c->id }}">
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
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <input type="hidden" name="comment_id" value="{{ $c->id }}">
                                    <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                                    <button type="submit" class="btn btn-outline-success">Submit</button>
                                </form>
                            </div>
                            <div class="collapse mt-3" id="collapse-comment-{{ $c->id }}-edit">
                                <form method="POST" action="{{ route('comment.update') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea class="form-control @error('comment') is-invalid @enderror"
                                            name="comment" id="comment" maxlength="255" cols="51" rows="3"
                                            placeholder="Write your comment here" required>{{ $c->comment }}</textarea>
                                        @error('comment')
                                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="id" value="{{ $c->id }}">
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <input type="hidden" name="thread_id" value="{{ $thread->id }}">

                                    <button type="submit" class="btn btn-outline-success">Submit</button>
                                </form>
                            </div>
                            <div class="collapse mt-3" id="collapse-comment-{{ $c->id }}-invalid">
                                <div class="alert alert-danger mt-3" role="alert">
                                    You must log in to comment!
                                </div>
                            </div>

                            @if ($c->replies != null)
                            @foreach ($c->replies as $rep)
                            <div class="card my-3">
                                <div class="media py-4 px-4">
                                    <div class="user mr-3">
                                        <img src="{{ url('/img/' . $imgName) }}" alt="..."
                                            style="width: 40px; height: 40px; border-radius:50%">
                                        <p><strong>{{ $rep->user->name }}</strong></p>
                                        <p><small>{{ date_format($rep->updated_at, 'd-m-Y') }}</small></p>
                                        <p><small>{{ date_format($rep->updated_at, 'H:i') }}</small></p>
                                    </div>
                                    <div class="col media-body">
                                        <p class="mt-2">{{ $rep->reply }}</p>
                                        @if ($c->user_id == Auth::id())
                                        <button class="btn btn-outline-info btn-sm" type="button" data-toggle="collapse"
                                            data-target="#collapse-reply-{{ $rep->id }}-edit" aria-expanded="false"
                                            aria-controls="collapse-reply-{{ $rep->id }}">
                                            Edit
                                        </button>
                                        <div class="collapse mt-3" id="collapse-reply-{{ $rep->id }}-edit">
                                            <form method="POST" action="{{ route('reply.update') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <textarea class="form-control @error('reply') is-invalid @enderror"
                                                        name="reply" id="reply" maxlength="255" cols="51" rows="3"
                                                        placeholder="Write your reply here"
                                                        required>{{ $rep->reply }}</textarea>
                                                    @error('reply')
                                                    <div class="alert alert-danger" role="alert">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <input type="hidden" name="id" value="{{ $rep->id }}">
                                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                                <input type="hidden" name="thread_id" value="{{ $thread->id }}">

                                                <button type="submit" class="btn btn-outline-success">Submit</button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection