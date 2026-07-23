@extends('layouts.main')

@section('content')

    <h2>Все посты</h2>

    <div class="post-list">
        @foreach($posts as $post)
            <div class="post-item">
                <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                <span class="badge">{{ $post->category_name }}</span>
            </div>
        @endforeach
    </div>

@endsection
