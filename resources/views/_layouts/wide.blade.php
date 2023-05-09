<!DOCTYPE html>
<html lang="en" class="h-100">

@include("_layouts/_head")

<body class="d-flex flex-column">
@include("_layouts/_navbar")
@yield('cover1')

<main class="flex-grow-1">
    @yield('content')
</main>

<div class="toast-container position-fixed p-3 bottom-0 end-0"></div>
{{--@vite('resources/js/app.js')--}}
@yield('inline_scripts')

</body>
</html>
