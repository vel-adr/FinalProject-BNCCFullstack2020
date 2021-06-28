@php
$imgName = $ts->photo;
@endphp

@extends('layouts.app')

@section('title', '{{ $thread->title }}')

@section('content')
<div class="container">
    <div class="row thread-content">
        <div class="col">

            {{-- Thread Card --}}
            <div class="card">
                {{-- Card Header --}}
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="{{ url('/img/' . $imgName) }}" style="width: 40px; height:40px; border-radius:50%; object-fit: cover;"
                                class="float-left mr-3">
                            <div class="d-flex align-items-center">
                                <p class="tslogo">&nbsp;<strong>TS</strong>&nbsp;</p>
                                <p style="font-size: 1.2em">&nbsp;<a
                                        href="/user/{{ $ts->id }}">{{ $ts->name }}</a>&nbsp;</p>
                                <p class="text-secondary">
                                    <small>{{ date_format($thread->created_at, 'd-m-Y H:i') }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">

                            <h5 class="card-title m-0">
                                @if ($thread->status == "close")
                                <i class="fas fa-lock" style="color: #c82a32"></i>&nbsp;
                                @endif
                                <strong>{{ $thread->title }}</strong>
                            </h5>
                        </li>
                        <li class="list-group-item">
                            <p class="card-text">{{ $thread->content }}</p>
                        </li>
                    </ul>
                </div>

                {{-- Card Footer --}}
                <div class="card-footer">
                    <div class="row justify-content-end mx-2">
                        @if ($thread->user_id == Auth::id())
                        <small><a href="/thread/{{ $thread->id }}/edit" class="text-secondary mx-3"><i
                                    class="fas fa-pen"></i> Edit
                                Thread</a>
                        </small>
                        @endif

                        @if ($thread->status == "open")
                        <!-- Check if thread status is open, if true show comment button -->

                        {{--Button to trigger comment form collapse --}}
                        @if(Auth::id() == null)
                        <small>
                            <a class="text-secondary" data-toggle="collapse" href="#collapse-comment-invalid"
                                role="button" aria-expanded="false" aria-controls="collapseExample"><i
                                    class="fas fa-comment"></i>
                                Comment
                            </a>
                        </small>

                        @else
                        <small><a class="text-secondary mx-2" data-toggle="collapse" href="#collapse-comment"
                                role="button" aria-expanded="false" aria-controls="collapseExample"><i
                                    class="fas fa-comment"></i>
                                Comment
                            </a></small>

                        @if (Auth::id() == $thread->user_id)
                        <small>
                            <a class="text-secondary mx-2" href="#"
                                onclick="event.preventDefault(); document.getElementById('delete-form').submit();">
                                <i class="fas fa-trash-alt"></i>&nbsp;Delete thread
                            </a>
                        </small>
                        <form action="/thread/{{ $thread->id }}" method="POST" id="delete-form">
                            @method('delete')
                            @csrf
                        </form>
                        @endif
                        @endif

                        @endif
                    </div>

                    @if ($thread->status == "open")
                    <div class="row">
                        <div class="col">
                            {{-- Comment Form for logged in user --}}
                            <div class="collapse mt-3" id="collapse-comment">
                                <form method="POST" action="{{ route('comment.create') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea class="form-control @error('comment') is-invalid @enderror"
                                            name="comment" id="comment" maxlength="255" cols="51" rows="3"
                                            placeholder="Tulis comment agan disini" required></textarea>
                                        @error('comment')
                                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                                    <button type="submit" class="btn btn-primary">Post</button>
                                </form>
                            </div>

                            {{-- Alert collapse for guest --}}
                            <div class="collapse mt-3" id="collapse-comment-invalid">
                                <div class="alert alert-danger mt-3" role="alert">
                                    You must log in to comment!
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Error alert for guest who submit comment form --}}
    @error('user_id')
    <div class="alert alert-danger alert-dismissible mt-3 fade show" role="alert">
        You must log in to comment!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @enderror

    {{-- Comments container --}}
    <div class="thread-comments mt-3">

        @foreach ($comments as $c)
        {{-- Comment card --}}
        <div class="card my-3">

            {{-- Header --}}
            <div class="card-header">
                <div class="row">
                    <div class="col-md-5">
                        @php
                        $imgName = $c->user->photo;
                        @endphp
                        <img src="{{ url('/img/' . $imgName) }}" style="width: 40px; height: 40px; border-radius:50%; object-fit: cover;"
                            class="float-left mr-3">
                        <div class="d-flex align-items-center">
                            @if ($c->user_id == $ts->id)
                            <p class="tslogo">&nbsp;<strong>TS</strong>&nbsp;</p>
                            @endif
                            <p style="font-size: 1.2em">&nbsp;<a
                                    href="/user/{{ $c->user_id }}">{{ $c->user->name }}</a>&nbsp;
                            </p>
                            <p class="text-secondary">
                                <small>{{ date_format($c->created_at, 'd-m-Y H:i') }}</small></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="card-body">
                {{-- Content row --}}
                <div class="row content">
                    <div class="col">
                        <p>{{ $c->comment }}</p>
                    </div>
                </div>

                {{-- Button row --}}
                <div class="row buttons justify-content-end">
                    @if ($thread->status == "open")
                    {{-- If user is the owner of comment show reply, delete, and edit button --}}
                    @if ($c->user_id == Auth::id())
                    <small>
                        <a class="text-secondary mx-3" data-toggle="collapse"
                            href="#collapse-comment-{{ $c->user_id }}-edit" role="button" aria-expanded="false"><i
                                class="fas fa-pen"></i>
                            Edit</a>
                    </small>
                    <small>
                        <a href="#" class="text-secondary mx-3"
                            onclick="event.preventDefault(); document.getElementById('deleteform-comment-{{ $c->id }}').submit();"><i
                                class="fas fa-trash-alt"></i> Delete</a>
                    </small>
                    @endif

                    @if (Auth::id() != null)
                    {{-- Logged in user reply button --}}
                    <small>
                        <a class="text-secondary mx-3" data-toggle="collapse" href="#collapse-comment-{{ $c->user_id }}"
                            role="button" aria-expanded="false"><i class="fas fa-reply"></i>
                            Reply
                        </a>
                    </small>

                    {{-- Guest reply button --}}
                    @else
                    <small>
                        <a class="text-secondary mx-3" data-toggle="collapse"
                            href="#collapse-comment-{{ $c->id }}-invalid" role="button" aria-expanded="false"><i
                                class="fas fa-reply"></i>
                            Reply
                        </a>
                    </small>
                    @endif

                    {{-- Delete form --}}
                    <form action="{{ route('comment.delete', ['id' => $c->id]) }}" method="POST"
                        id="deleteform-comment-{{ $c->id }}">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                    </form>
                    @endif

                </div>

                @if ($thread->status == "open")
                <div class="row">
                    <div class="col">

                        {{-- Reply form for logged in user --}}
                        <div class="collapse mt-3" id="collapse-comment-{{ $c->user_id }}">
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
                                <button type="submit" class="btn btn-primary">Post</button>
                            </form>
                        </div>

                        {{-- Reply Form for guest --}}
                        <div class="collapse mt-3" id="collapse-comment-{{ $c->id }}-invalid">
                            <div class="alert alert-danger mt-3" role="alert">
                                You must log in to comment!
                            </div>
                        </div>

                        {{-- Update form --}}
                        <div class="collapse mt-3" id="collapse-comment-{{ $c->user_id }}-edit">
                            <form method="POST" action="{{ route('comment.update') }}">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control @error('comment') is-invalid @enderror" name="comment"
                                        id="comment" maxlength="255" cols="51" rows="3"
                                        placeholder="Write your comment here" required>{{ $c->comment }}</textarea>
                                    @error('comment')
                                    <div class="alert alert-danger" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                                <input type="hidden" name="id" value="{{ $c->id }}">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="thread_id" value="{{ $thread->id }}">

                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Replies --}}
                @if ($c->replies != null)
                @foreach ($c->replies as $r)
                <div class="row ml-3 mt-3">
                    <div class="col">
                        <div class="card">

                            {{-- Header --}}
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-5">
                                        @php
                                        $imgName = $r->user->photo;
                                        @endphp
                                        <img src="{{ url('/img/' . $imgName) }}" style="width: 40px; height: 40px; border-radius:50%; object-fit: cover;"
                                            class="float-left mr-3">
                                        <div class="d-flex align-items-center">
                                            @if ($r->user_id == $ts->id)
                                            <p class="tslogo">&nbsp;<strong>TS</strong>&nbsp;</p>
                                            @endif
                                            <p style="font-size: 1.2em">&nbsp;<a
                                                    href="/user/{{ $r->user_id }}">{{ $r->user->name }}</a>&nbsp;
                                            </p>
                                            <p class="text-secondary">
                                                <small>{{ date_format($r->created_at, 'd-m-Y H:i') }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Body --}}
                            <div class="card-body">
                                <p>{{ $r->reply }}</p>
                            </div>

                            {{-- Footer --}}
                            @if ($thread->status == "open" && $r->user_id == Auth::id())
                            <div class="card-footer">

                                {{-- Button row --}}
                                <div class="row justify-content-end">
                                    {{-- Show edit and delete button --}}
                                    <small>
                                        <a class="text-secondary mx-3" data-toggle="collapse"
                                            href="#collapse-reply-{{ $r->id }}-edit" role="button"
                                            aria-expanded="false"><i class="fas fa-pen"></i>
                                            Edit</a>
                                    </small>
                                    <small>
                                        <a href="#" class="text-secondary mx-3"
                                            onclick="event.preventDefault(); document.getElementById('deleteform-reply-{{ $r->id }}').submit();"><i
                                                class="fas fa-trash-alt"></i> Delete</a>
                                    </small>

                                    {{-- Delete form --}}
                                    <form action="{{ route('reply.delete', ['id' => $r->id]) }}" method="POST"
                                        id="deleteform-reply-{{ $r->id }}">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                                    </form>
                                </div>

                                {{-- Collapse row --}}
                                <div class="row">
                                    <div class="col">
                                        {{-- Edit form for reply owner --}}
                                        <div class="collapse mt-3" id="collapse-reply-{{ $r->id }}-edit">
                                            <form method="POST" action="{{ route('reply.update') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <textarea class="form-control @error('reply') is-invalid @enderror"
                                                        name="reply" id="reply" maxlength="255" cols="51" rows="3"
                                                        placeholder="Write your reply here"
                                                        required>{{ $r->reply }}</textarea>
                                                    @error('reply')
                                                    <div class="alert alert-danger" role="alert">{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <input type="hidden" name="id" value="{{ $r->id }}">
                                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                                <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection

<style>
    .tslogo {
        background-color: #f5cb42;
        border-radius: 35%;
    }
</style>