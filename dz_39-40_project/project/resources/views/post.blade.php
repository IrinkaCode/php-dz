@extends('layouts.main')

@section('content')
    <article class="post-detail">
        <h2>{{ $post->title }}</h2>
        <p class="post-meta">Категория: <span class="badge">{{ $post->category->name }}</span></p>
        <p>{{ $post->content }}</p>
    </article>

    <section class="comments">
        <h3>Комментарии ({{ $post->comments->count() }})</h3>

        @forelse ($post->comments as $comment)
            <div class="comment">
                <div class="comment-header">
                    <span class="comment-author">{{ $comment->user->name }}</span>
                    <span class="comment-date">{{ $comment->created_at->format('d.m.Y H:i') }}</span>
                </div>
                <p class="comment-content">{{ $comment->content }}</p>
            </div>
        @empty
            <p class="empty">Комментариев пока нет</p>
        @endforelse
    </section>
@endsection
