<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Блог</title>
    <link rel="stylesheet" href="/styles/app.css">
</head>
<body>
@include('components.menu')

<main class="container">
    @yield('content')
</main>
</body>
</html>
