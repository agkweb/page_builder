<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <link rel="stylesheet" href="/panel/bootstrap-4.6.2-dist/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="/panel/css/survey.css" rel="stylesheet" />
    <title>{{ $survey->title }}</title>
</head>


<!-- main-content -->

<body class="flex">
<div class="wrapper my-2">
    <div class="quiz-container">
        <div class="quiz-head">
            <h1 class="quiz-title">{{ $survey->title }}</h1>
        </div>
        <div class="quiz-body">
            <h2 class="quiz-question" id="question"></h2>
            <ul class="quiz-options text-right" id="options"></ul>
            <div id="result"></div>
        </div>
        <div class="quiz-foot">
            <button type="button" id="next-question">سوال بعدی</button>
            <div class="quiz-score flex"> 
                <!-- <span id="current-quiz">1</span>/<span id="total-quiz">{{ $survey->questions->count() }}</span> -->
                <div id="question-counter">سوال <span id="current-question">1</span> از <span id="total-questions">{{ $survey->questions->count() }}</span></div> </div>
        </div>
    </div>


    <script src="/panel/bootstrap-4.6.2-dist/js/bootstrap.min.js"></script>
    <script src="/panel/js/libs/jquery.min.js"></script>
    <!-- <script src="/panel/js/survey.js"></script> -->

    <!-- {{ $survey->questions->first()->answers }} -->
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

        $(document).ready(function(){ 
            showQuestion(quizzes[currentQuiz]);
            // console.log(quizzes[currentQuiz])
            _nextQuestionBtn.addEventListener('click', function(){ 
                if(currentQuiz < totalQuiz - 1) { 
                    currentQuiz++; 
                    showQuestion(quizzes[currentQuiz]);
                    updateCounter(); 
                } else { 
                    _result.innerHTML = `<p>پرسش‌نامه به پایان رسید.</p>`; 
                    _nextQuestionBtn.style.display = 'none'; 
                } 
                _currentQuiz.textContent = currentQuiz + 1;
            });
        });

        function showQuestion(data){ 
            _question.innerHTML = data.title;
            _options.innerHTML = data.answers.map((answers, index) => 
            ` <li>${index + 1}. <span>${answers.title}</span></li> `).join(''); selectOption();
                }

        function selectOption(){ 
            _options.querySelectorAll('li').forEach(function(option){ 
                option.addEventListener('click', function(){ 
                    if(_options.querySelector('.selected')){ 
                        const activeOption = _options.querySelector('.selected'); 
                        activeOption.classList.remove('selected'); 
                    } 
                    option.classList.add('selected'); 
                }); 
            }); 
        }

        function updateCounter(){ 
            _currentQuestion.textContent = currentQuiz + 1; 
        }

    </script>
</body>

</html>