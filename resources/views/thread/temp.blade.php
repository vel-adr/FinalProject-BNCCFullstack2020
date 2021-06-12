{{-- Masukin ke div comment --}}

<div class="row my-3">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-1 d-flex justify-content-right align-items-center">
                        <img src="{{ url('/img/' . $imgName) }}" alt="avatar"
                            style="width: 40px; height: 40px; border-radius:50%">
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <div>{{ $c->user->name }}</div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                <div>{{ $c->created_at }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <a href="/thread/{{ $c->id }}/edit" class="btn btn-outline-success">Edit</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $c->comment }}</p>
            </div>
            <div class="card-footer">
                <button class="btn btn-outline-info btn-sm" type="button" data-toggle="collapse"
                    data-target="#commentcollapse{{ $c->id }}" aria-expanded="false"
                    aria-controls="commentcollapse{{ $c->id }}">
                    Comment
                </button>
                <div class="collapse mt-3" id="commentcollapse{{ $c->id }}">
                    <form method="POST" action="{{ route('reply.create') }}">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control @error('comment') is-invalid @enderror" name="comment"
                                id="comment-{{ $c->id }}" maxlength="255" cols="51" rows="3"
                                placeholder="Write your comment here" required></textarea>
                            @error('comment')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- sementara profileid selalu 1 karena belum ada login --}}
                        <input type="hidden" name="user_id" value="1">
                        <input type="hidden" name="comment_id" value="{{ $c->id }}">

                        <button type="submit" class="btn btn-outline-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>