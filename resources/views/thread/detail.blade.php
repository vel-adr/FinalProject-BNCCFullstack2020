@php
$imgName = $ts->photo;
@endphp

@extends('layouts.app')

@section('title', '{{ $thread->title }}')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-1 d-flex justify-content-right align-items-center">
                            <img src="{{ url('/img/' . $imgName) }}" alt=""
                                style="width: 40px; height: 40px; border-radius:50%">
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div>{{ $ts->name }}</div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    <div>{{ $thread->created_at }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <a href="/thread/{{ $thread->id }}/edit" class="btn btn-outline-success">Edit Thread</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="card-title">{{ $thread->title }}</h4>
                    <p class="card-text">{{ $thread->content }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection