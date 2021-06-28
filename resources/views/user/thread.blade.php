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

        @if (count($threads) > 0)
        <ul class="list-group list-group-flush">
            @foreach ($threads as $t)
            <li class="list-group-item">
                <p class="text-secondary">
                    <small><i class="fas fa-pen"></i> Create a thread - {{ date_format($t->created_at, 'd-m-Y H:i') }}
                    </small>
                </p>
                <h4>
                    <a href="/thread/{{ $t->id }}">{{ $t->title }}</a>
                </h4>
                <p class="text-truncate">{{ $t->content }}</p>
            </li>
            @endforeach
        </ul>

        @else
        <div class="row">
            <div class="col">
                <p class="text-secondary text-center">Agan belum pernah membuat thread</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection