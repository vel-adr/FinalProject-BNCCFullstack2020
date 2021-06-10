@extends('layouts.app')

@section('title', 'Create new thread')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 d-flex align-items-center">
            <h2>Thread list</h2>
        </div>
        <div class="col d-flex align-items-center justify-content-end">
            <a href="/thread/create" class="btn btn-outline-success">Create new thread</a>
        </div>
    </div>
</div>

<div class="container mt-4">
    @foreach ($threads as $t)
    @php
    $url = '/thread' . '/' . $t->id;
    @endphp
    <div class="row my-2">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="/thread/{{ $t->id }}" class="stretched-link">{{ $t->title }}</a>
                    </h5>
                    <p class="card-text text-truncate">{{ $t->content }}</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
{{-- <li>
             <span>
                    <form action="{{ url($url) }}" method="POST">
@csrf
@method('delete')
<button type="submit" class="btn btn-outline-danger">Delete Thread</button>
</form>
</span></a>
</li> --}}
@endsection