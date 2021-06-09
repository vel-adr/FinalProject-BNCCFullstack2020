@extends('layouts.app')

@section('title', '{{ $user->name }}')

@section('content')
    <div class="container">
        @php
        $imgName = $user->photo;
        @endphp
        <img src="{{ url('/img/' . $imgName) }}" alt="" style="width: 40px; height: 40px; border-radius:50%">
        <p>Name: {{ $user->name }}</p>
        <p>Joined {{ $user->created_at }}</p>
        <h4>Thread list:</h4>
        <ul>
            @foreach ($threads as $t)
                <li>{{ $t->title }}</li>
            @endforeach
        </ul>
    </div>
@endsection