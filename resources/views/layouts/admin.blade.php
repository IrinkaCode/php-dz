<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админка</title>
    <link rel="stylesheet" href="/styles/app.css">
</head>
<body>
@include('components.admin.menu')

<main class="container">
    @include('components.messages')

    @yield('content')
</main>
</body>
</html>
