@extends('layouts.admin')

@section('content')
    <h2>Редактировать пост #{{ $post->id }}</h2>

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <p>
            <label>Заголовок<br>
                <input type="text" name="title" value="{{ old('title', $post->title) }}">
            </label>
        </p>

        <p>
            <label>Категория<br>
                <select name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected($category->id === $post->category_id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </label>
        </p>

        <p>
            <label>Содержание<br>
                <textarea name="content" rows="6" cols="60">{{ old('content', $post->content) }}</textarea>
            </label>
        </p>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('admin.posts.index') }}" class="btn">Отмена</a>
    </form>
@endsection
