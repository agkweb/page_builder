<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }}</title>
    <style>
        {!! $page->css !!}
    </style>
</head>
<body>
    @include('layout.errors')
    {!! $page->html !!}

    <script>
        function nextStep() {
            document.querySelector('.form-step-1').style.display = 'none';
            document.querySelector('.form-step-2').style.display = 'block';
        }
    </script>
</body>
</html>