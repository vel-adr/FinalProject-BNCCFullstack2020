@extends('layouts.app')

@section('title', '{{ $thread->title }}')

@section('content')
<div class="container">
    <h1>{{ $thread->title }}</h1>
    <p>{{ $thread->content }}</p>
</div>
@endsection