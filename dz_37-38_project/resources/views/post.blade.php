@extends('layouts.main')

@section('content')
    @if (!is_null($post))
        <article class="post-detail">
            <h2>{{ $post->title }}</h2>
            <p class="post-meta">Категория: <span class="badge">{{ $post->category_name }}</span></p>
            <p>{{ $post->content }}</p>
        </article>
    @else
        <p class="empty">Нет такого поста</p>
    @endif

@endsection
