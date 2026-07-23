@extends('layouts.admin')

@section('content')
    <h2>Добавить пост</h2>

    <form action="{{ route('admin.posts.store') }}" method="POST" class="form">
        @csrf

        <p>
            <label>Заголовок<br>
                <input type="text" name="title" value="{{ old('title') }}">
            </label>
        </p>

        <p>
            <label>Категория<br>
                <select name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </label>
        </p>

        <p>
            <label>Содержание<br>
                <textarea name="content" rows="6" cols="60">{{ old('content') }}</textarea>
            </label>
        </p>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('admin.posts.index') }}" class="btn">Отмена</a>
    </form>
@endsection
