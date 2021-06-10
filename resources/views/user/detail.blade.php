@extends('layouts.app')

@php
$imgName = $user->photo;
@endphp

@section('title', '{{ $user->name }}')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-1 d-flex justify-content-right align-items-center">
            <img src="{{ url('/img/' . $imgName) }}" alt="" style="width: 40px; height: 40px; border-radius:50%">
        </div>
        <div class="col">
            <div class="row">
                <div class="col">
                    <div>{{ $user->name }}</div>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <div>Joined {{ $user->created_at }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <h2>Thread list:</h2>
        </div>
    </div>

    <ul class="list-group list-group-flush">
        @foreach ($threads as $t)
        <li class="list-group-item">{{ $t->title }}}</li>
        @endforeach
    </ul>

</div>
@endsection