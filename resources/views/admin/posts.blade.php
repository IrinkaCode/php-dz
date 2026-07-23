@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>CRUD постов</h2>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">+ Добавить пост</a>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Заголовок</th>
            <th>Категория</th>
            <th>Создан</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @forelse($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                {{-- Категория берётся через отношение (загружена жадно в контроллере через with('category')) --}}
                <td><span class="badge">{{ $post->category?->name }}</span></td>
                <td>{{ $post->created_at }}</td>
                <td class="actions">
                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm">Редактировать</a>

                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить пост?')">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="empty">Постов пока нет</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $posts->links('components.pagination') }}
@endsection
