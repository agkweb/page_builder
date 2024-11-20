<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('assets/panel/css/survey.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/panel/css/bootstrap-4.6.2-dist/bootstrap.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('assets/panel/js/libs/jquery.min.js') }}"></script>
    <title>{{ $survey->title }}</title>
    <script>
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        document.addEventListener('DOMContentLoaded', function() {
            let surveyCompleted = getCookie('surveyCompleted');
            if (surveyCompleted) {
                alert('شما قبلا داخل این نظرسنجی شرکت کردید!');
                window.location = "{{ url('https://agkins.com') }}";
                document.querySelector('.quiz-container').style.display = 'none';
            } else {
                document.querySelector('.quiz-container').style.display = 'block';
            }
        });

        function completeSurvey() {
            // Set survey completed cookie
            setCookie('surveyCompleted', 'true', 30); // Store for 30 days

            let browserId = localStorage.getItem('browserId');
            if (!browserId) {
                browserId = `browser_${Math.random().toString(36).substr(2, 9)}`;
                localStorage.setItem('browserId', browserId);
            }

            // Send final survey data to the server
            const activeOption = document.querySelector('.quiz-options .selected');
            fetch('/submit-survey', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    survey_data: {
                        survey_id: {{ $survey->id }},
                        question_id: quizzes[currentQuiz].id,
                        answer_id: activeOption.id,
                        browser_id: browserId
                    }
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Survey completed! Thank you.');
                        document.querySelector('.quiz-container').style.display = 'none';
                    } else {
                        alert(data.message || 'An error occurred.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>

<body class="flex flex-column">
    <div class="quiz-head my-3">
        <h1 class="quiz-title">{{ $survey->title }}</h1>
    </div>
    <div class="wrapper my-2">
        <div class="quiz-container">
            <div class="quiz-body" id="body">
                <h2 class="quiz-question" id="question"></h2>
                <ul class="quiz-options text-right" id="options"></ul>
                <div id="result"></div>
            </div>
            <div class="quiz-foot">
                <button type="button" id="next-question">سوال بعدی</button>
                <div class="quiz-score flex col-sm-4 col-7 rounded">
                    <div id="question-counter">
                        سوال
                        <span id="current-question">
                            1
                        </span>
                        از
                        <span id="total-questions">{{ $survey->questions->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let currentQuiz = 0;
        let totalQuiz = {{ $survey->questions->count() }};
        let quizzes = @json($survey->questions);

        const _question = document.getElementById('question');
        const _options = document.getElementById('options');
        const _nextQuestionBtn = document.getElementById('next-question');
        const _result = document.getElementById('result');
        const _currentQuiz = document.getElementById('current-quiz');
        const _totalQuiz = document.getElementById('total-quiz');
        const _currentQuestion = document.getElementById('current-question');
        const _totalQuestions = document.getElementById('total-questions');

        $(document).ready(function () {
            showQuestion(quizzes[currentQuiz]);
            _nextQuestionBtn.addEventListener('click', function () {
                if (currentQuiz < totalQuiz - 1) {
                    const activeOption = _options.querySelector('.selected');
                    $.ajax({
                        url: '{{ route('surveys.save') }}',
                        type: 'post',
                        data: {
                            survey_data: [
                                { survey_id: quizzes[currentQuiz].survey_id },
                                { question_id: quizzes[currentQuiz].id },
                                { answer_id: activeOption.id }
                            ]
                        },
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function (response) {
                            console.log(response);
                        },
                        error: function (xhr) {
                            console.log(xhr);
                        }
                    });
                    currentQuiz++;
                    showQuestion(quizzes[currentQuiz]);
                    updateCounter();
                } else {
                    const activeOption = _options.querySelector('.selected');
                    completeSurvey();
                    $.ajax({
                        url: '{{ route('surveys.save') }}',
                        type: 'post',
                        data: {
                            survey_data: [
                                { survey_id: quizzes[currentQuiz].survey_id },
                                { question_id: quizzes[currentQuiz].id },
                                { answer_id: activeOption.id }
                            ]
                        },
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function (response) {
                            console.log(response);
                        },
                        error: function (xhr) {
                            console.log(xhr);
                        }
                    });
                    _result.innerHTML = `<form class="row d-flex my-2 justify-content-center" id="" method="post" action="{{ route('surveys.add_phoneNumber') }}" >
                <input class="col-6 rounded" type="tel" id="phone" name="phone_number" placeholder="09123456789" pattern="09[0-9]{9}" required style="box-shadow: 1px 4px 4px 0 #e6e1eb">
                @csrf
                <input type="hidden" value="{{ $survey->id }}" name="survey_id">
                <button class="btn btn-info mx-2 col-5" type="submit" style="box-shadow: 1px 4px 4px 0 #e6e1eb">ثبت اطلاعات</button>
                </form>`;
                    _nextQuestionBtn.style.display = 'none';
                }
                _currentQuiz.textContent = currentQuiz + 1;
            });
        });

        function showQuestion(data) {
            _question.innerHTML = data.title;
            _options.innerHTML = data.answers.map((answers, index) =>
                `<li style="direction: rtl;" id="${answers.id}">${index + 1}. <span>${answers.title}</span></li> `).join(''); selectOption();
        }

        function selectOption() {
            _options.querySelectorAll('li').forEach(function (option) {
                option.addEventListener('click', function () {
                    if (_options.querySelector('.selected')) {
                        const activeOption = _options.querySelector('.selected');
                        activeOption.classList.remove('selected');
                    }
                    option.classList.add('selected');
                });
            });
        }

        function updateCounter() {
            _currentQuestion.textContent = currentQuiz + 1;
        }

        // Check if a browser ID already exists in localStorage
        let browserId = localStorage.getItem('browserId');
        if (!browserId) {
            // Generate a unique browser ID
            browserId = `browser_${Math.random().toString(36).substr(2, 9)}`;
            localStorage.setItem('browserId', browserId);
        }
        fetch('/validate-browser', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ browserId: browserId })
        })
            .then(response => response.json())
            .then(data => {
                if (data.allowed) {
                    // Allow the user to access the survey
                    // document.getElementById('surveyForm').style.display = 'block';
                } else {
                    // Display an error message or redirect the user
                    // alert('Access denied');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    </script>
    <script src="{{ asset('assets/panel/js/libs/bootstrap-4.6.2-dist/bootstrap.min.js') }}"></script>
</body>

</html>
