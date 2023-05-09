<!DOCTYPE html>
<html lang="en" class="h-100">

@include("_layouts/_head")

<body class="d-flex flex-column">
@include("_layouts/_navbar")
@yield('cover1')

<main class="flex-grow-1">
    <div class="container py-4">
        @yield('content')
    </div>
</main>

@include("_layouts/_footer")

<div class="toast-container position-fixed p-3 bottom-0 end-0"></div>

@yield('inline_scripts')

@if(session('status'))
    <script type="text/javascript">
        window.addEventListener('load', function() {
            window.showToast2(@json(session('status')));
        })
    </script>
@endif

</body>
</html>
