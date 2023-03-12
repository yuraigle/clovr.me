<!DOCTYPE html>
<html lang="en" class="h-100">

@include("layouts/_head")

<body class="d-flex flex-column">
@include("layouts/_navbar")
@yield('cover1')

<main class="flex-grow-1">
    <div class="container py-4">
        @yield('content')
    </div>
</main>

@include("layouts/_footer")

<div class="toast-container position-fixed p-3 bottom-0 end-0"></div>
<script type="text/javascript" src="{{ mix('/dist/common.js') }}"></script>
@yield('inline_scripts')

@if (session('status'))
    <script type="text/javascript">window.showToast2(@json(session('status')));</script>
@endif

</body>
</html>
