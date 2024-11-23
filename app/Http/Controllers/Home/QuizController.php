<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Response;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index(): View|Factory|Application
    {
        $quizzes = Quiz::latest()->paginate(10);
        return view('quizzes/index', compact('quizzes'));
    }

    public function create(): Factory|View|Application
    {
        return view('quizzes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validateWithBag('createQuiz', [
            'title' => 'required',
            'description' => 'required',
            'is_active' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $quiz = Quiz::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => '1',
                'is_active' => $request->is_active
            ]);

            foreach ($request->questions as $questionData){
                $quizQuestion = QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'text' => $questionData['text'],
                    'status' => '1'
                ]);
//                foreach ($questionData['options'] as $option){
//                    if ($option){
//                        QuizOption::create([
//                            'question_id' => $question->id,
//                            'text' => $option,
//                            'is_correct' => $option
//                            'status' => 1
//                        ]);
//                    }
//                }
            }
            DB::commit();
        }catch (Exception $ex) {
            DB::rollBack();
            flash()->flash("error", $ex->getMessage(), [], 'مشکلی پیش آمد');
        }

        flash()->flash("success", 'با موفقیت به آزمون ها اضافه شد.', [], 'موفقیت آمیز');
        return redirect()->route('quizzes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz): View|Factory|Application
    {
        return view('quizzes/show', compact('quiz'));
    }

    public function preview(Quiz $quiz): View|Factory|Application
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($quiz->id);
        return view('quizzes/preview', compact('quiz'));
    }

    public function validateBrowser(Request $request): JsonResponse
    {
        $browserId = $request->input('browserId');

        // Perform your validation logic here
        // For example, you can check if the browser ID exists in a database of allowed IDs
        $allowed = $this->isBrowserIdAllowed($browserId);

        return response()->json(['allowed' => $allowed]);
    }

    private function isBrowserIdAllowed($browserId): bool
    {
        // Example validation logic (replace with your actual logic)
        $allowedBrowserIds = [
            'browser_abc123', // Replace with actual allowed browser IDs
            'browser_def456',
            // Add more allowed browser IDs here
        ];

        return in_array($browserId, $allowedBrowserIds);
    }


/**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz): View|Factory|Application
    {
        return view('quizzes.edit', compact('quiz'));
    }

    public function edit_question(Question $question): View|Factory|Application
    {
        return view('quizzes.edit_question', compact('question'));
    }

    public function update_question(Request $request, Question $question): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'answers.*' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $question->update([
                'title' => $request->title
            ]);

            foreach ($request->answers as $key => $newAnswerTitle){
                Answer::findOrFail($key)->update([
                    'title' => $newAnswerTitle
                ]);
            }

            if ($request->newAnswers != null){
                foreach ($request->newAnswers as $newAnswer){
                    Answer::create([
                        'question_id' => $question->id,
                        'title' => $newAnswer,
                        'status' => '1'
                    ]);
                }
            }

            DB::commit();
        }catch (Exception $ex) {
            DB::rollBack();
            flash()->flash("error", $ex->getMessage(), [], 'مشکلی پیش آمد');
            return redirect()->back();
        }

        flash()->flash("success", 'پرسشنامه مورد نظر با موفقیت ویرایش شد!', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    public function delete_answer(Answer $answer): RedirectResponse
    {
        $answer->delete();
        flash()->flash("success", 'پاسخ مورد نظر با موفقیت حذف شد!', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    public function delete_question(Question $question): RedirectResponse
    {
        $question->delete();
        flash()->flash("success", 'سوال مورد نظر با موفقیت حذف شد!', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'is_active' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $quiz->update([
                'title' => $request->title,
                'description' => $request->description,
                'is_active' => $request->is_active
            ]);

            if ($request->questions){
                $step = 0;
                foreach ($request->questions as $questionData){
                    $step++;
                    $question = Question::create([
                        'quiz_id' => $quiz->id,
                        'step' => $step,
                        'title' => $questionData['question'],
                        'type' => 'option',
                        'status' => '1'
                    ]);
                    foreach ($questionData['answers'] as $answer){
                        if ($answer){
                            Answer::create([
                                'question_id' => $question->id,
                                'title' => $answer,
                                'status' => 1
                            ]);
                        }
                    }
                }
            }

            DB::commit();
        }catch (Exception $ex) {
            DB::rollBack();
            flash()->flash("error", $ex->getMessage(), [], 'مشکلی پیش آمد');
            return redirect()->back();
        }

        flash()->flash("success", 'پرسشنامه مورد نظر با موفقیت ویرایش شد!', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    public function destroy(Quiz $quiz): RedirectResponse
    {
        $quiz->delete();
        flash()->flash("success", 'پرسشنامه مورد نظر با موفقیت حذف شد!', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    public function save(Request $request): void
    {
        $quizData = $request->input('quiz_data');
        Response::create([
            'quiz_id' => $quizData[0]['quiz_id'],
            'question_id' => $quizData[1]['question_id'],
            'answer_id' => $quizData[2]['answer_id'],
        ]);
    }

    public function search(): Factory|View|Application
    {
        $keyword = request()->keyword;
        if (request()->has('keyword') && trim($keyword) != ''){
            $quizzes = Quiz::where('title', 'LIKE', '%'.trim($keyword).'%')->latest()->paginate(10);
        }else{
            $quizzes = Quiz::latest()->paginate(10);
        }
        return view('quizzes/index' , compact('quizzes'));
    }

    public function searchFromTrash(): View|Factory|Application
    {
        $keyword = request()->keyword;
        if (request()->has('keyword') && trim($keyword) != ''){
            $quizzes = Quiz::onlyTrashed()->where('title', 'LIKE', '%'.trim($keyword).'%')->latest()->paginate(10);
        }else{
            $quizzes = Quiz::onlyTrashed()->latest()->paginate(10);
        }
        return view('quizzes/trash' , compact('quizzes'));
    }

    public function trash(): View|Factory|Application
    {
        $quizzes = Quiz::onlyTrashed()->orderBy('status', 'desc')->latest()->paginate(10);
        return view('quizzes/trash', compact('quizzes'));
    }

    public function restore(Request $request): RedirectResponse
    {
        Quiz::onlyTrashed()->find($request->quiz)->restore();
        flash()->flash("success", 'پرسش نامه مورد نظر با موفقیت بازگردانی شد!', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    public function export(Quiz $quiz): Application|Factory|View|RedirectResponse
    {
        return view('quizzes.export', compact('quiz'));
    }

    public function exportInExcel(Request $request, Quiz $quiz): StreamedResponse
    {
        $request->validate([
            'start' => 'required',
            'end' => 'required',
        ]);

        $fileName = 'quizzes.csv';

        $responses = Response::where('quiz_id', $quiz->id)->whereBetween('created_at',[convertToGregorianDate($request->start), convertToGregorianDate($request->end)])->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($responses) {
            $columns = ['آیدی', 'پاسخ', 'تاریخ ایجاد رکورد'];
            $file = fopen('php://output', 'w');
            fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
            fputcsv($file, $columns);

            if ($responses){
                foreach ($responses as $response) {
                    $row = [
                        $response->id,
                        $response->answer->title,
                        verta($response->created_at),
                    ];

                    fputcsv($file, $row);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
