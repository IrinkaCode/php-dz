@extends('layouts.admin')

@section('content')
    <h2>Редактировать категорию #{{ $category->id }}</h2>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <p>
            <label>Название<br>
                <input type="text" name="name" value="{{ old('name', $category->name) }}">
            </label>
        </p>

        <p>
            <label>Slug<br>
                <input type="text" name="slug" value="{{ old('slug', $category->slug) }}">
            </label>
        </p>

        <p>
            <label>Описание<br>
                <textarea name="description" rows="4" cols="60">{{ old('description', $category->description) }}</textarea>
            </label>
        </p>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('admin.categories.index') }}" class="btn">Отмена</a>
    </form>
@endsection
