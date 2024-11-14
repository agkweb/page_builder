<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Question;
use App\Models\Registration;
use App\Models\Survey;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
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
        dd($request->all());
        $request->validateWithBag('createSurvey', [
            'title' => 'required',
            'description' => 'required',
            'is_active' => 'nullable',
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

            // add questions
            foreach ($request->question_titles as $question_title){
                $step++;
                $question = Question::create([
                    'survey_id' => $survey->id,
                    'step' => $step,
                    'title' => $question_title['title'],
                    'type' => 'option',
                    'status' => '1'
                ]);
            }

//            $responses = $request->question_responses;
//
//            foreach (){
//                $first = array_slice($responses, $step, 4);
//                $step++;
//            }

            DB::commit();
        }catch (Exception $ex) {
            DB::rollBack();
            flash()->flash("error", $ex->getMessage(), [], 'مشکلی پیش آمد');
        }

        flash()->flash("success", 'با موفقیت به پرسش نامه ها اضافه شد.', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Survey $survey): View|Factory|Application
    {
        return view('surveys/show', compact('survey'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Survey $survey)
    {
        return view('surveys.update', compact('survey'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page): RedirectResponse
    {
//        $validator = Validator::make($request->all(), [
//            'title' => 'required|min:3',
//            'category_id' => 'required',
//            'html' => 'required|string',
//            'css' => 'required|string'
//        ]);
//
//        if($validator->fails()){
//            return back()->withErrors($validator, 'updatePage')->withInput()->with(['page_id' => $page->id]);
//        }
//
//        try {
//            DB::beginTransaction();
//
//            $hasForm = containsForm($request->html);
//
//            $page->update([
//                'title' => $request->title,
//                'category_id' => $request->category_id,
//                'user_id' => '1',
//                'html' => $request->html,
//                'css' => $request->css,
//                'status' => $hasForm ? 2 : 1,
//            ]);
//
//            DB::commit();
//        }catch (Exception $ex) {
//            DB::rollBack();
//            flash()->flash("error", $ex->getMessage(), [], 'مشکلی پیش آمد');
//            return redirect()->back();
//        }
//
//        flash()->flash("success", 'صفحه مورد نظر با موفقیت ویرایش شد!', [], 'موفقیت آمیز');
//        return redirect()->back();
    }

    public function destroy(Survey $survey): RedirectResponse
    {
        $survey->delete();
        flash()->flash("success", 'پرسشنامه مورد نظر با موفقیت حذف شد!', [], 'موفقیت آمیز');
        return redirect()->back();
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

    public function export(Survey $survey)
    {
        if ($survey->status != 2){
            flash()->flash("warning", 'پرسش نامه مورد نظر فرم ندارد!', [], 'پرسش نامه اشتباه!');
            return redirect()->back();
        }else{
            return view('surveys.export', compact('survey'));
        }
    }

    public function exportInExcel(Request $request, Page $page): StreamedResponse
    {
//        $request->validate([
//            'start' => 'required',
//            'end' => 'required',
//        ]);
//
//        $fileName = 'registrations.csv';
//
//        $registrations = Registration::where('page_id', $page->id)->whereBetween('created_at',[convertToGregorianDate($request->start), convertToGregorianDate($request->end)])->get();
//
//        $headers = [
//            "Content-type"        => "text/csv",
//            "Content-Disposition" => "attachment; filename=$fileName",
//            "Pragma"              => "no-cache",
//            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
//            "Expires"             => "0"
//        ];
//
//        $callback = function() use ($registrations,) {
//            $columns = ['آیدی', 'نام و نام خانوادگی', 'شماره تلفن', 'ایمیل', 'مدرک', 'رشته', 'دانشگاه', 'استان', 'شهر', 'تاریخ ایجاد رکورد'];
//            $file = fopen('php://output', 'w');            // Adding BOM to ensure UTF-8 support in Excel
//            fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
//            fputcsv($file, $columns);
//
//            foreach ($registrations as $registration) {
//                $row = [
//                    $registration->id,
//                    $registration->fullname,
//                    $registration->phone_number,
//                    $registration->email,
//                    $registration->license,
//                    $registration->major,
//                    $registration->university,
//                    $registration->province ? $registration->province->name : '',
//                    $registration->city ? $registration->city->name : '',
//                    verta($registration->created_at),
//                ];
//
//                fputcsv($file, $row);
//            }
//
//            fclose($file);
//        };
//
//        return response()->stream($callback, 200, $headers);
    }
}
