@extends('layouts.main')

@section('content')

    <h2>Все посты</h2>

    <nav class="category-filter">
        <a href="{{ route('posts.index') }}" @class(['active' => !isset($category_id)])>Все категории</a>
        @foreach($categories as $category)
            <a
                href="{{ route('posts.category', $category->slug) }}"
                @class(['active' => isset($category_id) && $category_id === $category->id])
            >{{ $category->name }}</a>
        @endforeach
    </nav>

    <div class="post-list">
        @forelse($posts as $post)
            <div class="post-item">
                <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                <span class="badge">{{ $post->category->name }}</span>
            </div>
        @empty
            <p class="empty">В этой категории пока нет постов</p>
        @endforelse
    </div>

    {{ $posts->links('components.pagination') }}

@endsection
