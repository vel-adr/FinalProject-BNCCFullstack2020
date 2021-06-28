@extends('layouts.app')

@section('title', 'Create new thread')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h2>Thread list</h2>
        </div>
    </div>
</div>

<div class="container">

    @if ($threads->total() > 0)
    <div class="row my-2">
        @foreach ($threads as $t)
        @php
        $url = '/thread' . '/' . $t->id;
        @endphp

        <div class="col-lg-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex">
                            <a class="my-2" href="/user/{{ $t->user_id }}"><small>{{ $t->user->name }}</small></a>
                            <p class="text-secondary my-2"><small>&nbsp;•
                                    {{ date_format($t->created_at, 'd-m-Y H:i') }}</small></p>
                        </div>
                    </div>
                    <h5 class="card-title">
                        @if ($t->status == "close")
                        <i class="fas fa-lock" style="color: #c82a32"></i>&nbsp;
                        @endif
                        <a href="/thread/{{ $t->id }}">{{ $t->title }}</a>
                    </h5>
                    <p class="card-text text-truncate">{{ $t->content }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @else
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-center">
                <p class="text-secondary">Belum ada yang membuat thread nih gan..</p>
            </div>
        </div>
    </div>
    @endif

    <div class="row mt-5 justify-content-center">
        {{ $threads->links() }}
    </div>
</div>
@endsection