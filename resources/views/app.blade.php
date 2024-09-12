<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Ticket Manager</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles & Scripts -->
    @viteReactRefresh
    @vite('resources/css/app.css')
    @vite('resources/js/index.jsx') <!-- Main entry point for React -->
</head>
    <body class="font-sans antialiased">
        <div id="app"></div> <!-- React will mount here -->
    </body>
</html>