@extends('layouts.app')

@php
$profileImg = $user->photo;
$coverImg = $user->cover;
@endphp

@section('title', '{{ $user->name }}')

@section('content')
<div class="container">
    {{-- User info --}}
    <div class="card">
        <div class="card-body p-0 overflow-hidden">
            <div class="row cover">
                <img src="{{ url('/img/' . $coverImg) }}" alt="" style="width: 100%; height: 150px; background-position: center; object-fit: cover">
            </div>
            <div class="row align-items-end px-3" style="position: relative; top: -30px">
                <div class="col-lg-1 mr-5 no-gutters">
                    <img src="{{ url('/img/' . $profileImg) }}" alt=""
                        style="width: 100px; height: 100px; border-radius:50%; border: 4px solid #fff; object-fit:cover">
                </div>

                <div class="col-lg-8">
                    <div class="row">
                        <div class="col">
                            <h3>{{ $user->name }}</h3>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <div>Bergabung {{ date_format($user->created_at, "d - m - Y") }}</div>
                        </div>
                    </div>
                </div>

                @if ($user->id == Auth::id())
                <div class="col justify-content-lg-end d-flex mt-3">
                    <a href="/user/{{ $user->id }}/edit" class="btn btn-outline-success"><i class="fas fa-pen"></i> Edit
                        Profile</a>
                </div>
                @endif
                
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

        <div class="col mt-3">
            @yield('usercontent')
        </div>
    </div>
</div>
@endsection