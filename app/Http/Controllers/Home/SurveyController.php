<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Page;
use App\Models\Question;
use App\Models\Registration;
use App\Models\Response;
use App\Models\Survey;
use App\Models\SurveyUser;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Factory|Application
    {
        $surveys = Survey::latest()->paginate(10);
        return view('surveys/index', compact('surveys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|View|Application
    {
        return view('surveys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validateWithBag('createSurvey', [
            'title' => 'required',
            'description' => 'required',
            'is_active' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $survey = Survey::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => '1',
                'is_active' => $request->is_active
            ]);

            $step = 0;
            foreach ($request->questions as $questionData){
                $step++;
                $question = Question::create([
                    'survey_id' => $survey->id,
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
            DB::commit();
        }catch (Exception $ex) {
            DB::rollBack();
            flash()->flash("error", $ex->getMessage(), [], 'مشکلی پیش آمد');
        }

        flash()->flash("success", 'با موفقیت به پرسش نامه ها اضافه شد.', [], 'موفقیت آمیز');
        return redirect()->route('surveys.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Survey $survey): View|Factory|Application
    {
        return view('surveys/show', compact('survey'));
    }

    public function preview(Survey $survey): View|Factory|Application
    {
        $survey = Survey::with('questions.answers')->findOrFail($survey->id);
        return view('surveys/preview', compact('survey'));
    }

    public function validateBrowser(Request $request)
    {
        $browserId = $request->input('browserId');

        // Perform your validation logic here
        // For example, you can check if the browser ID exists in a database of allowed IDs
        $allowed = $this->isBrowserIdAllowed($browserId);

        return response()->json(['allowed' => $allowed]);
    }

    private function isBrowserIdAllowed($browserId)
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
    public function edit(Survey $survey): View|Factory|Application
    {
        return view('surveys.edit', compact('survey'));
    }

    public function edit_question(Question $question): View|Factory|Application
    {
        return view('surveys.edit_question', compact('question'));
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
    public function update(Request $request, Survey $survey): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'is_active' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $survey->update([
                'title' => $request->title,
                'description' => $request->description,
                'is_active' => $request->is_active
            ]);

            if ($request->questions){
                $step = 0;
                foreach ($request->questions as $questionData){
                    $step++;
                    $question = Question::create([
                        'survey_id' => $survey->id,
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

    public function destroy(Survey $survey): RedirectResponse
    {
        $survey->delete();
        flash()->flash("success", 'پرسشنامه مورد نظر با موفقیت حذف شد!', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    public function save(Request $request): void
    {
        $surveyData = $request->input('survey_data');
        Response::create([
            'survey_id' => $surveyData[0]['survey_id'],
            'question_id' => $surveyData[1]['question_id'],
            'answer_id' => $surveyData[2]['answer_id'],
        ]);
    }

    public function add_phoneNumber(Request $request): RedirectResponse
    {
        $request->validate([
            'phone_number' => 'required|string|min:11|max:11|starts_with:09',
            'survey_id' => 'required',
        ]);
        SurveyUser::create([
            'phone_number' => $request->phone_number,
            'survey_id' => $request->survey_id
        ]);
        flash()->flash("success", 'ممنون از همکاری شما!', [], 'موفقیت آمیز');
        return redirect('https://agkins.com');
    }

    public function search(): Factory|View|Application
    {
        $keyword = request()->keyword;
        if (request()->has('keyword') && trim($keyword) != ''){
            $surveys = Survey::where('title', 'LIKE', '%'.trim($keyword).'%')->latest()->paginate(10);
        }else{
            $surveys = Survey::latest()->paginate(10);
        }
        return view('surveys/index' , compact('surveys'));
    }

    public function searchFromTrash(): View|Factory|Application
    {
        $keyword = request()->keyword;
        if (request()->has('keyword') && trim($keyword) != ''){
            $surveys = Survey::onlyTrashed()->where('title', 'LIKE', '%'.trim($keyword).'%')->latest()->paginate(10);
        }else{
            $surveys = Survey::onlyTrashed()->latest()->paginate(10);
        }
        return view('surveys/trash' , compact('surveys'));
    }

    public function trash(): View|Factory|Application
    {
        $surveys = Survey::onlyTrashed()->orderBy('status', 'desc')->latest()->paginate(10);
        return view('surveys/trash', compact('surveys'));
    }

    public function restore(Request $request): RedirectResponse
    {
        Survey::onlyTrashed()->find($request->survey)->restore();
        flash()->flash("success", 'پرسش نامه مورد نظر با موفقیت بازگردانی شد!', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    public function export(Survey $survey): Application|Factory|View|RedirectResponse
    {
        return view('surveys.export', compact('survey'));
    }

    public function exportInExcel(Request $request, Survey $survey): StreamedResponse
    {
        $request->validate([
            'start' => 'required',
            'end' => 'required',
        ]);

        $fileName = 'surveys.csv';

        $responses = Response::where('survey_id', $survey->id)->whereBetween('created_at',[convertToGregorianDate($request->start), convertToGregorianDate($request->end)])->get();

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
