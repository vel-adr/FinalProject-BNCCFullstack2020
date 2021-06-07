@extends('layouts.app')

@section('title', 'Create new thread')

@section('content')
<div class="container">
    <h1>Thread list:</h1>
    <ul>
        @foreach ($threads as $t)
            <li><a href="/thread/{{ $t->id }}">{{ $t->title }}</a></li>
        @endforeach
    </ul>
    <a href="/thread/create" class="btn btn-outline-success">Create new thread</a>
</div>
@endsection