@extends('layouts.app')

@section('title', 'Create new comment')

@section('content')
    <div class="container">
        <h1>Create a question</h1>
        <form method="POST" action="{{ route('comment.create') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="comment">Comment: </label>
                <textarea class="form-control @error('comment') is-invalid @enderror" name="comment" id="comment"
                    maxlength="255" cols="51" rows="5" placeholder="Write your comment here" required></textarea>
                @error('comment')
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                @enderror
            </div>
    
            {{-- sementara profileid selalu 1 karena belum ada login --}}
            <input type="hidden" name="user_id" value="1">
            <input type="hidden" name="thread_id" value="{{ $id }}">
    
            <button type="submit" class="btn btn-outline-success">Submit</button>
        </form>
    </div>
@endsection