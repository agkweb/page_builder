<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <link rel="stylesheet" href="/panel/bootstrap-4.6.2-dist/css/bootstrap.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="{{ asset('assets/panel/css/survey.css') }}" rel="stylesheet" />
    <title>کارنامه های برتر</title>
</head>

<!-- main-content -->
<body class="flex">
<div class="wrapper my-2">
    <div class="quiz-container">
        <div class="quiz-head">
            <h1 class="quiz-title">عنوان پرسش نامه</h1>
        </div>
        <div class="quiz-body">
            <h2 class="quiz-question" id="question">... تو اگه با من قهری</h2>
            <ul class="quiz-options text-right">
                <li>من که آشتیم</li>
                <li>من که دوستتم</li>
                <li>بیا قهر نباشیم</li>
                <li>به درک که قهری</li>
            </ul>
            <div id="result"></div>
        </div>
        <div class="quiz-foot">
            <button type="button" id="check-answer">ثبت پاسخ</button>
            <button type="button" id="play-again">Play Again!</button>
            <div class="quiz-score flex">
                <span id="correct-score">1</span>/<span id="total-question">10</span>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/panel/bootstrap-4.6.2-dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/panel/js/survey.js') }}"></script>

</body>
</html>
