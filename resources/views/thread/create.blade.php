@extends('layouts.app')

@section('title', 'Create new thread')

@section('content')
<div class="container">
    <h1>Create a question</h1>
    <form method="POST" action="{{ url('/thread') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="title">Thread title: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input class="form-control" type="text" name="title" id="title"
                placeholder="Write your thread's title here" maxlength="45" size="45" required>
        </div>
        {{-- @error('title')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror --}}

        <div class="mb-3">
            <label class="form-label" for="content">Content: </label>
            <textarea class="form-control" name="content" id="content" maxlength="255" cols="51" rows="5"
                placeholder="Write your thread's content here" required></textarea>
        </div>
        {{-- @error('content')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror --}}

        {{-- sementara profileid selalu 1 karena belum ada login --}}
        <input type="hidden" name="user_id" value="1">
        <input type="hidden" name="status" value="open">

        <button type="submit" class="btn btn-outline-success">Submit</button>
    </form>
</div>

@endsection