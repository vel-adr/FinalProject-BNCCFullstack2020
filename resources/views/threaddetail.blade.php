@extends('layouts.app')

@section('title', '{{ $thread->title }}')

@section('content')
<div class="container">
    <h1>{{ $thread->title }}</h1>
    <p>{{ $thread->content }}</p>
    <a href="/thread/{{ $thread->id }}/edit" class="btn btn-outline-success">Edit Thread</a>
</div>
@endsection