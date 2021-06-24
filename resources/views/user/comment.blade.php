@php
$data = array();

foreach($comments as $c){
$arr = [
"type"=>"comment",
"last_update"=>$c->updated_at,
"data"=>$c
];

array_push($data, $arr);
}

foreach($replies as $r){
$arr = [
"type"=>"reply",
"last_update"=>$r->updated_at,
"data"=>$r
];

array_push($data, $arr);
}

$update = array_column($data, 'last_update');
array_multisort($update, SORT_DESC, $data);
@endphp

@extends('user.layoutdetail')

@section('usercontent')
<div class="card">
    <ul class="nav nav-tabs">
        <li class="nav-item mx-2">
            <a class="nav-link" aria-current="page" href="/user/{{ $user->id }}">Post</a>
        </li>
        <li class="nav-item mx-2">
            <a class="nav-link" href="/user/{{ $user->id }}/thread">Thread</a>
        </li>
        <li class="nav-item mx-2">
            <a class="nav-link active" href="#">Comment & Replies</a>
        </li>
    </ul>
</div>

<div class="card mt-3">
    <div class="card-body">
        <ul class="list-group list-group-flush">
            @foreach ($data as $d)

            @if ($d["type"] == "comment")
            <li class="list-group-item">
                <p class="text-secondary">
                    <small><i class="fas fa-comment"></i> Membalas thread <a
                            href="/user/{{ $d["data"]->thread->user_id }}">{{ $d["data"]->thread->user->name }}</a> -
                        {{ $d["data"]->created_at }} </small>
                </p>
                <h4>
                    <a href="/thread/{{ $d["data"]->thread_id }}">{{ $d["data"]->thread->title }}</a>
                </h4>
                <p>{{ $d["data"]->comment }}</p>
            </li>
            @endif

            @if ($d["type"] == "reply")
            <li class="list-group-item">
                <p class="text-secondary">
                    <small><i class="fas fa-reply"></i> Membalas comment
                        <a href="/user/{{ $d["data"]->comment->user_id }}">{{ $d["data"]->comment->user->name }}</a> -
                        {{ $d["data"]->created_at }} </small>
                </p>
                <h4>
                    <a href="/thread/{{ $d["data"]->comment->thread_id }}">{{ $d["data"]->comment->thread->title }}</a>
                </h4>
                <p>{{ $d["data"]->reply }}</p>
            </li>
            @endif

            @endforeach
        </ul>
    </div>
</div>
@endsection