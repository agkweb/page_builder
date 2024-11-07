<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    @include('sections.links')
    <title>@yield('title')</title>
</head>
<body class="navbar-fixed sidebar-nav fixed-nav">
@include('sections.header')
@include('sections.sidebar')

    <main class="main">
        @yield('content')
    </main>

@include('sections.footer')
@include('sections.scripts')
@yield('scripts')
</body>
</html>
