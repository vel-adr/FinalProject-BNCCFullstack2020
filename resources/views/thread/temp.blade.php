<div class="card-header">
    <div class="row justify-content-between">
        <div class="col d-flex align-items-center">
            <img src="{{ url('/img/' . $imgName) }}" alt="" style="width: 40px; height: 40px; border-radius:50%">
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

        {{-- Edit thread button --}}
        @if (Auth::id() == $thread->user_id)
        <div class="col-sm-2">
            <a href="/thread/{{ $thread->id }}/edit" class="btn btn-outline-success">Edit Thread</a>
        </div>
        @endif
    </div>
</div>



{{-- Comment --}}
<div class="row">
    <div class="col-md-12">
        <div class="media px-4 py-4 my-3">

            {{-- User row --}}
            <div class="user mr-3">
                <img src="{{ url('/img/' . $imgName) }}" alt="..." style="width: 40px; height: 40px; border-radius:50%">
                <p><strong>{{ $c->user->name }}</strong></p>
                <p>{{ date_format($c->updated_at, 'd-m-Y') }}</p>
                <p>{{ date_format($c->updated_at, 'H:i') }}</p>
            </div>

            {{-- Body row --}}
            <div class="col media-body">
                <p class="mt-2">{{ $c->comment }}</p>
                @if ($thread->status == "open")
                <!-- Check thread status, if true show reply button -->
                <button class="btn btn-outline-info btn-sm" type="button" data-toggle="collapse"
                    data-target="#collapse-comment-{{ $c->id }}@if(Auth::id()==null){{ "-invalid" }}@endif"
                    aria-expanded="false" aria-controls="collapse-comment-{{ $c->id }}">
                    Reply
                </button>
                @endif


                @if ($c->user_id == Auth::id() && $thread->status == "open")
                {{-- Check if the comment belongs to user that logged in and if thread status is open, if true show edit and delete button --}}
                {{-- Edit button --}}
                <button class="btn btn-outline-info btn-sm" type="button" data-toggle="collapse"
                    data-target="#collapse-comment-{{ $c->id }}-edit" aria-expanded="false"
                    aria-controls="collapse-comment-{{ $c->id }}">
                    Edit
                </button>

                {{-- Delete button --}}
                <form action="{{ route('comment.delete', ['id' => $c->id]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                </form>
                {{-- @endif asalnya disini --}}

                {{-- Reply Form (Collapse) --}}
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

                {{-- Comment Update Form (Collapse) --}}
                <div class="collapse mt-3" id="collapse-comment-{{ $c->id }}-edit">
                    <form method="POST" action="{{ route('comment.update') }}">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control @error('comment') is-invalid @enderror" name="comment"
                                id="comment" maxlength="255" cols="51" rows="3" placeholder="Write your comment here"
                                required>{{ $c->comment }}</textarea>
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
                @endif

                {{-- Reply Form Alert for guest --}}
                <div class="collapse mt-3" id="collapse-comment-{{ $c->id }}-invalid">
                    <div class="alert alert-danger mt-3" role="alert">
                        You must log in to comment!
                    </div>
                </div>


                @if ($c->replies != null)
                <!-- Check if there are replies for this comment-->
                @foreach ($c->replies as $rep)
                <!-- Loop to show if there is any -->
                <div class="card my-3">
                    <div class="media py-4 px-4">

                        {{-- User row --}}
                        <div class="user mr-3">
                            <img src="{{ url('/img/' . $imgName) }}" alt="..."
                                style="width: 40px; height: 40px; border-radius:50%">
                            <p><strong>{{ $rep->user->name }}</strong></p>
                            <p><small>{{ date_format($rep->updated_at, 'd-m-Y') }}</small></p>
                            <p><small>{{ date_format($rep->updated_at, 'H:i') }}</small></p>
                        </div>

                        {{-- Body row --}}
                        <div class="col media-body">
                            <p class="mt-2">{{ $rep->reply }}</p>

                            @if ($c->user_id == Auth::id() && $thread->status == "open")
                            <!-- To check if the reply belongs to user that logged in -->

                            {{-- Reply edit button --}}
                            <button class="btn btn-outline-info btn-sm" type="button" data-toggle="collapse"
                                data-target="#collapse-reply-{{ $rep->id }}-edit" aria-expanded="false"
                                aria-controls="collapse-reply-{{ $rep->id }}">
                                Edit
                            </button>

                            {{-- Reply delete button --}}
                            <form action="{{ route('reply.delete', ['id' => $rep->id]) }}" method="POST">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                            </form>

                            {{-- Reply update form --}}
                            <div class="collapse mt-3" id="collapse-reply-{{ $rep->id }}-edit">
                                <form method="POST" action="{{ route('reply.update') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea class="form-control @error('reply') is-invalid @enderror" name="reply"
                                            id="reply" maxlength="255" cols="51" rows="3"
                                            placeholder="Write your reply here" required>{{ $rep->reply }}</textarea>
                                        @error('reply')
                                        <div class="alert alert-danger" role="alert">{{ $message }}
                                        </div>
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