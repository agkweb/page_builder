<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageForm;
use App\Models\Registration;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrations = Registration::latest()->paginate(10);
        return view('registrations/index', compact('registrations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        $categories = Category::active()->get();
//        return view('pages.make');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'page_id' => 'required',
            'fullname' => 'nullable|string',
            'phone_number' => 'required|string',
            'email' => 'nullable|email',
            'degree' => 'nullable|string',
            'field' => 'nullable|string',
            'university_name' => 'nullable|string',
            'province_id' => 'nullable',
            'city_id' => 'nullable',
            'attachment' => [
                'nullable',
                File::types(['pdf', 'jpg'])
                    ->max('3mb'),
            ],
        ]);

        try {
            DB::beginTransaction();

            $existedData = array_filter($request->all(), function ($value){
               return !is_null($value);
            });

            $registrations = Registration::create($existedData);

            DB::commit();
        }catch (Exception $ex) {
            DB::rollBack();
            flash()->flash("error", $ex->getMessage(), [], 'مشکلی پیش آمد');
        }

        flash()->flash("success", 'اطلاعات با موفقیت ذخیره شد.', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(Request $request, PageForm $pageForm): RedirectResponse
//    {
//        $validator = Validator::make($request->all(), [
//            'page_id' => 'required',
//            'fullname' => 'nullable|string',
//            'phone_number' => 'required|string',
//            'email' => 'nullable|email',
//            'degree' => 'nullable|string',
//            'field' => 'nullable|string',
//            'university_name' => 'nullable|string',
//            'province_id' => 'nullable',
//            'city_id' => 'nullable',
//            'attachment' => [
//                'nullable',
//                File::types(['pdf', 'jpg'])
//                    ->max('5mb'),
//            ],
//        ]);
//
//        if($validator->fails()){
//            return back()->withErrors($validator, 'updatePageForm')->withInput()->with(['pageForm_id' => $pageForm->id]);
//        }
//
//        try {
//            DB::beginTransaction();
//
//            $existedData = array_filter($request->all(), function ($value){
//                return !is_null($value);
//            });
//
//            $pageForm->update($existedData);
//
//            DB::commit();
//        }catch (Exception $ex) {
//            DB::rollBack();
//            flash()->flash("error", $ex->getMessage(), [], 'مشکلی پیش آمد');
//            return redirect()->back();
//        }
//
//        flash()->flash("success", 'اطلاعات مورد نظر با موفقیت ویرایش شد!', [], 'موفقیت آمیز');
//        return redirect()->back();
//    }
//
//    public function destroy(PageForm $pageForm): RedirectResponse
//    {
//        $pageForm->delete();
//        flash()->flash("success", 'اطلاعات مورد نظر با موفقیت حذف شد!', [], 'موفقیت آمیز');
//        return redirect()->back();
//    }

    public function search(): Factory|View|Application
    {
        $keyword = request()->keyword;
        if (request()->has('keyword') && trim($keyword) != ''){
            $registrations = Registration::where('phone_number', 'LIKE', '%'.trim($keyword).'%')->latest()->paginate(10);
        }else{
            $registrations = Registration::latest()->paginate(10);
        }
        return view('pageForms/index' , compact('registrations'));
    }
}
