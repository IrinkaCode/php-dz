@extends('layouts.admin')

@section('content')
    <h2>Добавить категорию</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="form">
        @csrf

        <p>
            <label>Название<br>
                <input type="text" name="name" value="{{ old('name') }}">
            </label>
        </p>

        <p>
            <label>Slug<br>
                <input type="text" name="slug" value="{{ old('slug') }}">
            </label>
        </p>

        <p>
            <label>Описание<br>
                <textarea name="description" rows="4" cols="60">{{ old('description') }}</textarea>
            </label>
        </p>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('admin.categories.index') }}" class="btn">Отмена</a>
    </form>
@endsection
