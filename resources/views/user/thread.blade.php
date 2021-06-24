@extends('user.layoutdetail')

@section('usercontent')
<div class="card">
    <ul class="nav nav-tabs">
        <li class="nav-item mx-2">
            <a class="nav-link" aria-current="page" href="/user/{{ $user->id }}">Post</a>
        </li>
        <li class="nav-item mx-2">
            <a class="nav-link active" href="#">Thread</a>
        </li>
        <li class="nav-item mx-2">
            <a class="nav-link" href="/user/{{ $user->id }}/comment">Comment & Replies</a>
        </li>
    </ul>
</div>

<div class="card mt-3">
    <div class="card-body">
        <ul class="list-group list-group-flush">
            @foreach ($threads as $t)
            <li class="list-group-item">
                <p class="text-secondary">
                    <small><i class="fas fa-pen"></i> Create a thread - {{ $t->created_at }} </small>
                </p>
                <h4>
                    <a href="/thread/{{ $t->id }}">{{ $t->title }}</a>
                </h4>
                <p class="text-truncate">{{ $t->content }}</p>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection