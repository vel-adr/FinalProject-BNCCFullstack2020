@extends('layouts.app')

@section('title', 'Create new thread')

@section('content')
<div class="container">
    <h1>Thread list:</h1>
    <ul>
        @foreach ($threads as $t)
        @php
        $url = '/thread' . '/' . $t->id;
        @endphp
        <li>
            <a href="/thread/{{ $t->id }}">{{ $t->title }} <span>
                    <form action="{{ url($url) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-outline-danger">Delete Thread</button>
                    </form>
                </span></a>
        </li>
        @endforeach
    </ul>
    <a href="/thread/create" class="btn btn-outline-success">Create new thread</a>
</div>
@endsection