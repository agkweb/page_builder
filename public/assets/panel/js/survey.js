let currentQuiz = 0; 
let totalQuiz = 0; 
let quizzes = [];

const _question = document.getElementById('question'); 
const _options = document.getElementById('options'); 
const _nextQuestionBtn = document.getElementById('next-question'); 
const _result = document.getElementById('result'); 
const _currentQuiz = document.getElementById('current-quiz'); 
const _totalQuiz = document.getElementById('total-quiz'); 
const _currentQuestion = document.getElementById('current-question'); 
const _totalQuestions = document.getElementById('total-questions');

$(document).ready(function(){ 
    loadQuestions(); 
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


function loadQuestions(){ 
    $.ajax({ 
        url: 'http://localhost:8000/surveys/1/questions', 
        method: 'GET', 
        success: function(data) { 
            quizzes = data; 
            console.log(data);
            totalQuiz = quizzes.length; 
            _totalQuiz.textContent = totalQuiz; 
            _totalQuestions.textContent = totalQuiz; 
            showQuestion(quizzes[currentQuiz]); 
            updateCounter(); 
        } 
    });
 }
 



 function showQuestion(data){ 
    _question.innerHTML = data.question; 
    _options.innerHTML = JSON.parse(data.options).map((option, index) => ` <li>${index + 1}. <span>${option}</span></li> `).join(''); selectOption(); 
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



















// const _question = document.getElementById('question');
// const _options = document.querySelector('.quiz-options');
// const _checkBtn = document.getElementById('check-answer');
// // const _playAgainBtn = document.getElementById('play-again');
// // const _result = document.getElementById('result');
// const _correctScore = document.getElementById('current-quiz');
// const _totalQuestion = document.getElementById('total-quiz');


// let correctAnswer = "", correctScore = askedCount = 0, totalQuestion = 10;

// // load question from API
// async function loadQuestion(){
//     const APIUrl = 'http://localhost:8000/surveys/1/questions';
//     const result = await fetch(`${APIUrl}`)
//     const data = await result.json();
//     // _result.innerHTML = "";
//     showQuestion(data.results[0]);
//     console.log(data);
// }
// loadQuestion()
// // event listeners
// function eventListeners(){
//     _checkBtn.addEventListener('click', checkAnswer);
//     _playAgainBtn.addEventListener('click', restartQuiz);
// }

// document.addEventListener('DOMContentLoaded', function(){
//     loadQuestion();
//     eventListeners();
//     _totalQuestion.textContent = totalQuestion;
//     _correctScore.textContent = correctScore;
// });


// // display question and options
// function showQuestion(data){
//     _checkBtn.disabled = false;
//     correctAnswer = data.correct_answer;
//     let incorrectAnswer = data.incorrect_answers;
//     let optionsList = incorrectAnswer;
//     optionsList.splice(Math.floor(Math.random() * (incorrectAnswer.length + 1)), 0, correctAnswer);
//     // console.log(correctAnswer);


//     _question.innerHTML = `${data.question} <br> <span class = "category"> ${data.category} </span>`;
//     _options.innerHTML = `
//         ${optionsList.map((option, index) => `
//             <li> ${index + 1}. <span>${option}</span> </li>
//         `).join('')}
//     `;
//     selectOption();
// }


// // options selection
// function selectOption(){
//     _options.querySelectorAll('li').forEach(function(option){
//         option.addEventListener('click', function(){
//             if(_options.querySelector('.selected')){
//                 const activeOption = _options.querySelector('.selected');
//                 activeOption.classList.remove('selected');
//             }
//             option.classList.add('selected');
//         });
//     });
// }

// // answer checking
// function checkAnswer(){
//     _checkBtn.disabled = true;
//     if(_options.querySelector('.selected')){
//         let selectedAnswer = _options.querySelector('.selected span').textContent;
//         if(selectedAnswer == HTMLDecode(correctAnswer)){
//             correctScore++;
//             _result.innerHTML = `<p><i class = "fas fa-check"></i>Correct Answer!</p>`;
//         } else {
//             _result.innerHTML = `<p><i class = "fas fa-times"></i>Incorrect Answer!</p> <small><b>Correct Answer: </b>${correctAnswer}</small>`;
//         }
//         checkCount();
//     } else {
//         _result.innerHTML = `<p><i class = "fas fa-question"></i>Please select an option!</p>`;
//         _checkBtn.disabled = false;
//     }
// }


// // to convert html entities into normal text of correct answer if there is any
// function HTMLDecode(textString) {
//     let doc = new DOMParser().parseFromString(textString, "text/html");
//     return doc.documentElement.textContent;
// }


// function checkCount(){
//     askedCount++;
//     setCount();
//     if(askedCount == totalQuestion){
//         setTimeout(function(){
//             console.log("");
//         }, 5000);


//         _result.innerHTML += `<p>Your score is ${correctScore}.</p>`;
//         _playAgainBtn.style.display = "block";
//         _checkBtn.style.display = "none";
//     } else {
//         setTimeout(function(){
//             loadQuestion();
//         }, 300);
//     }
// }

// function setCount(){
//     _totalQuestion.textContent = totalQuestion;
//     _correctScore.textContent = correctScore;
// }


// function restartQuiz(){
//     correctScore = askedCount = 0;
//     _playAgainBtn.style.display = "none";
//     _checkBtn.style.display = "block";
//     _checkBtn.disabled = false;
//     setCount();
//     loadQuestion();
// }
