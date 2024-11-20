<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }}</title>
    <script src="{{ asset('assets/panel/js/libs/jquery.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        {!! $page->css !!}
    </style>
</head>
<body>
    @include('layout.errors')
    {!! $page->html !!}

    <script>
        const form_step_1 = document.querySelector('.form-step-1');
        const form_step_2 = document.querySelector('.form-step-2');
        const next_form = document.querySelector('#nextForm');
        const input_phone_number = document.querySelector('#phone_number');
        const input_page_id = document.querySelector('#page_id');
        const input_2_phone_number = document.querySelector('#form_2_phone_number');
        const input_2_page_id = document.querySelector('#form_2_page_id');

        form_step_2.style.display = "none";
        input_page_id.value = {{ $page->id }};
        next_form.addEventListener('click', function() {
            if (input_phone_number.value.length === 11 && input_phone_number.value.startsWith("09")) {
                $.ajax({
                    url: '{{ route('registrations.storePhoneNumber') }}',
                    type: 'post',
                    data: {
                        form_step_one_data: [
                            { page_id: input_page_id.value },
                            { phone_number: input_phone_number.value }
                        ]
                    },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (response) {
                        if(response === 'error'){
                            alert('شما قبلااین فرم را تکمیل کردید. ممنون از همکاری شما!')
                        }else{
                            document.querySelector('.form-step-1').style.display = 'none';
                            document.querySelector('.form-step-2').style.display = 'block';
                            input_2_phone_number.value = input_phone_number.value
                            input_2_page_id.value = input_page_id.value
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr);
                    }
                });
            } else {
                alert('لطفاً شماره تلفن صحیح وارد کنید.');
            }

        });
    </script>
</body>
</html>
