@extends('layouts.admin')

@section('content')
    <h2>Добро пожаловать в админку</h2>

    <div class="stats">
        <div class="stat-card">
            <span class="stat-number">{{ $categoriesCount }}</span>
            <span class="stat-label">Категорий</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ $postsCount }}</span>
            <span class="stat-label">Постов</span>
        </div>
    </div>
@endsection
