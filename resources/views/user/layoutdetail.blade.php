@extends('layouts.app')

@php
$imgName = $user->photo;
@endphp

@section('title', '{{ $user->name }}')

@section('content')
<div class="container">
    {{-- User info --}}
    <div class="card">
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-lg-1 mr-5 no-gutters">
                    <img src="{{ url('/img/' . $imgName) }}" alt=""
                        style="width: 100px; height: 100px; border-radius:50%; border: 2px solid #282828">
                </div>

                <div class="col-md-8">
                    <div class="row">
                        <div class="col">
                            <h3>{{ $user->name }}</h3>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <div>Joined {{ date_format($user->created_at, "d - m - Y") }}</div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <a href="/user/{{ $user->id }}/edit" class="btn btn-outline-success"><i class="fas fa-pen"></i> Edit
                        Profile</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center">
                            <p>{{ count($threads) }}</p>
                            <p>Thread</p>
                        </div>
                        <div class="col text-center">
                            <p>{{ count($comments) }}</p>
                            <p>Comment</p>
                        </div>
                        <div class="col text-center">
                            <p>{{ count($replies) }}</p>
                            <p>Reply</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            @yield('usercontent')
        </div>
    </div>
</div>
@endsection