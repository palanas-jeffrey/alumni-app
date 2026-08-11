<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Resources -->
        <!-- <link rel="stylesheet" href="{{ public_path('css/bootstrap.min.css') }}"> -->
        <link rel="stylesheet" href="{{ base_path('public/css/bootstrap.min.css') }}">
        <!-- <link rel="stylesheet" href="{{ public_path('css/app.css') }}">
        <link rel="stylesheet" href="{{ public_path('css/styles.css') }}"> -->

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            <main>
                @yield('content')
            </main>
        </div>
    </body>
</html>
