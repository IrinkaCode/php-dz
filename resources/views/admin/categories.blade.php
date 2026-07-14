@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>CRUD категорий</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Добавить категорию</a>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Slug</th>
            <th>Постов</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td><code>{{ $category->slug }}</code></td>
                <td>{{ $category->posts_count }}</td>
                <td class="actions">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm">Редактировать</a>

                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить категорию?')">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="empty">Категорий пока нет</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
