<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
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
    public function create(Request $request): Factory|View|Application
    {
        $request->validateWithBag('validatingBasicInfo', [
            'title' => 'required',
            'description' => 'required'
        ]);

        $data = $request->all();

        return view('surveys.make', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
//        $request->validateWithBag('createSurvey', [
//            'title' => 'required',
//            'category_id' => 'required',
//            'html' => 'required|string',
//            'css' => 'required|string',
//            'is_active' => 'required'
//        ]);
//
//        try {
//            DB::beginTransaction();
//
//            $hasForm = containsForm($request->html);
//
//            Page::create([
//                'title' => $request->title,
//                'category_id' => $request->category_id,
//                'user_id' => '1',
//                'html' => $request->html,
//                'css' => $request->css,
//                'status' => $hasForm ? 2 : 1,
//                'is_active' => $request->is_active,
//            ]);
//
//            DB::commit();
//        }catch (Exception $ex) {
//            DB::rollBack();
//            flash()->flash("error", $ex->getMessage(), [], 'مشکلی پیش آمد');
//        }
//
//        flash()->flash("success", 'با موفقیت به صفحات اضافه شد.', [], 'موفقیت آمیز');
//        return redirect()->back();
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
    public function edit(Request $request, Survey $survey)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator, 'updateBasicInfo')->withInput()->with(['survey_id' => $survey->id]);
        }else{
            $survey = Survey::findOrFail($request->page_id);
            $survey->update([
                'title' => 'required',
                'description' => 'required'
            ]);
            return view('surveys.update', compact('survey'));
        }
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
//        $query = Survey::query();
//        $keyword = request()->keyword;
//        $filter = request()->filter;
//        if (request()->has('keyword') && trim($keyword) != ''){
//            $query->where('title', 'LIKE', '%'.trim($keyword).'%');
//        }
//        if(request()->has('filter') && trim($filter) != ''){
//            if ($filter != 0){
//                $query->where('status', '=', $filter);
//            }
//        }
//        $pages = $query->latest()->paginate(10);
//        return view('pages/index' , compact('pages'));
    }

    public function searchFromTrash(): View|Factory|Application
    {
//        $keyword = request()->keyword;
//        $categories = Category::get();
//        if (request()->has('keyword') && trim($keyword) != ''){
//            $pages = Page::onlyTrashed()->where('title', 'LIKE', '%'.trim($keyword).'%')->latest()->paginate(10);
//        }else{
//            $pages = Page::onlyTrashed()->latest()->paginate(10);
//        }
//        return view('pages/trash' , compact('pages', 'categories'));
    }

    public function trash(): View|Factory|Application
    {
//        $pages = Page::onlyTrashed()->orderBy('status', 'desc')->paginate(10);
//        $categories = Category::get();
//        return view('pages/trash', compact('pages', 'categories'));
    }

    public function restore(Request $request): RedirectResponse
    {
//        Page::onlyTrashed()->find($request->page)->restore();
//        flash()->flash("success", 'صفحه مورد نظر با موفقیت بازگردانی شد!', [], 'موفقیت آمیز');
//        return redirect()->back();
    }

    public function export(Survey $survey)
    {
//        if ($page->status != 2){
//            flash()->flash("warning", 'صفحه مورد نظر فرم ندارد!', [], 'صفحه اشتباه!');
//            return redirect()->back();
//        }else{
//            return view('pages.export', compact('page'));
//        }
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