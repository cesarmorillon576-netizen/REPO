<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <style>
        body { font-family: sans-serif; display: grid; place-items: center; min-height: 100vh; margin: 0; background: #f4f4f5; }
        main { background: #fff; padding: 2rem; border-radius: 8px; width: 320px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        label { display: block; margin-top: 1rem; }
        input { width: 100%; padding: .5rem; box-sizing: border-box; }
        button { margin-top: 1.5rem; width: 100%; padding: .6rem; }
        .servidor { color: #71717a; font-size: .85rem; margin: 0; }
        .error { color: #b91c1c; font-size: .9rem; }
    </style>
</head>
<body>
    <main>
        <p class="servidor">{{ config('app.name') }}</p>
        @yield('content')
    </main>
</body>
</html>
