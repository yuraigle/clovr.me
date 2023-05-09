<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('meta')

    <title>@yield('title')Clovr - Real Estate Marketplace</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png"/>
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png"/>
    <link rel="manifest" href="/site.1666414708.webmanifest"/>
    <meta name="theme-color" content="#aabe39"/>

    @vite('resources/sass/app.scss')
    @yield('inline_styles')
</head>
