<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'page_id' => 'required',
            'fullname' => 'nullable|string',
            'phone_number' => 'required|string|min:11|max:11|starts_with:09',
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
