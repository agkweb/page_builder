<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Factory|Application
    {
        $registrations = Registration::latest()->paginate(10);
        return view('registrations/index', compact('registrations'));
    }

    public function show(Registration $registration)
    {
        return view('registrations.show', compact('registration'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function storePhoneNumber(Request $request): string
    {
        $form_step_one_data = $request->input('form_step_one_data');

        $registration = Registration::where('phone_number', $form_step_one_data[1]['phone_number'])->where('page_id', $form_step_one_data[0]['page_id'])->first();

        if (!$registration){
            Registration::create([
                'page_id' => $form_step_one_data[0]['page_id'],
                'phone_number' => $form_step_one_data[1]['phone_number'],
            ]);
            return 'success';
            // send an SMS
        }else{
            return 'error';
        }
    }
    public function storeData(Request $request): RedirectResponse
    {
        $request->validate([
            'form_2_page_id' => 'required',
            'form_2_phone_number' => 'required|string|min:11|max:11|starts_with:09',
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

            $registration = Registration::where('phone_number', $request->form_2_phone_number)->where('page_id', $request->form_2_page_id)->first();

//            $existedData = array_filter($request->all(), function ($value){
//               return !is_null($value);
//            });

            $registration->update([
                'email' => $request->email ? $request->email : null,
                'fullname' => $request->fullname ? $request->fullname : null,
                'degree' => $request->degree ? $request->degree : null,
                'field' => $request->field ? $request->field : null,
                'university_name' => $request->university_name ? $request->university_name : null,
                'province_id' => $request->province_id ? $request->email : null,
                'city_id' => $request->city_id ? $request->city_id : null
            ]);

            DB::commit();
        }catch (Exception $ex) {
            DB::rollBack();
            flash()->flash("error", $ex->getMessage(), [], 'مشکلی پیش آمد');
        }

        flash()->flash("success", 'اطلاعات با موفقیت ذخیره شد.', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    public function search(): Factory|View|Application
    {
        $keyword = request()->keyword;
        if (request()->has('keyword') && trim($keyword) != ''){
            $registrations = Registration::whereHas('page', function ($query) use ($keyword){
                $query->where('title', 'LIKE', '%'.trim($keyword).'%');
            })->latest()->paginate(10);
        }else{
            $registrations = Registration::latest()->paginate(10);
        }
        return view('registrations/index' , compact('registrations'));
    }

}
