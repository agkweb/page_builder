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
        document.querySelector('.form-step-2').style.display = "none";
        document.querySelector('#page_id').value = {{ $page->id }};
        const nextBtn = document.querySelector('#nextForm');
        const input_phone_number = document.querySelector('#phone_number')
        nextBtn.addEventListener('click', function() {
            // const input_phone = document.querySelector('#name')
            const phoneNumber = input_phone_number.value;
            if (phoneNumber.length === 11 && phoneNumber.startsWith("09")) {
                document.querySelector('.form-step-1').style.display = 'none';
                console.log('efer')
                document.querySelector('.form-step-2').style.display = 'block';
            } else {
                alert('لطفاً شماره تلفن صحیح وارد کنید.');
            }

        });
    </script>
</body>
</html>
