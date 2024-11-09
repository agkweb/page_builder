<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Factory|Application
    {
        $categories = Category::latest()->paginate(10);
        return view('categories/index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Factory|Application
    {
        $parentCategories = Category::where('parent_id', '=', '0')->get();
        return view('categories/create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validateWithBag( 'createCategory',[
            'title' => 'required|min:3',
            'parent_id' => 'required',
            'is_active' => 'required'
        ]);

        try {
            DB::beginTransaction();

            Category::create([
                'title' => $request->title,
                'parent_id' => $request->parent_id,
                'status' => '1',
                'is_active' => $request->is_active
            ]);

            DB::commit();
        }catch (Exception $ex) {
            DB::rollBack();
            flash()->flash("error", $ex->getMessage(), [], 'مشکلی پیش آمد');
            return redirect()->back();
        }

        flash()->flash("success", 'با موفقیت به دسته بندی ها اضافه شد.', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): View|Factory|Application
    {
        return view('categories/show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View|Factory|Application
    {
        $parentCategories = Category::where('parent_id', '=', '0')->where('id', '!=', $category->id)->get();
        return view('categories/edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'parent_id' => 'required',
            'is_active' => 'required'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator, 'updateCategory')->withInput()->with(['category_id' => $category->id]);
        }

        try {
            DB::beginTransaction();

            $category->update([
                'title' => $request->title,
                'parent_id' => $request->parent_id,
                'status' => '1',
                'is_active' => $request->is_active
            ]);

            DB::commit();
        }catch (Exception $ex) {
            DB::rollBack();
            flash()->flash("error", $ex->getMessage(), [], 'مشکلی پیش آمد');
            return redirect()->back();
        }

        flash()->flash("success", 'دسته بندی مورد نظر با موفقیت ویرایش شد!', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        flash()->flash("success", 'دسته بندی مورد نظر با موفقیت حذف شد!', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    public function search(): Factory|View|Application
    {
        $keyword = request()->keyword;
        $parentCategories = Category::where('parent_id', '=', '0')->get();
        if (request()->has('keyword') && trim($keyword) != ''){
            $categories = Category::where('title', 'LIKE', '%'.trim($keyword).'%')->latest()->paginate(10);
        }else{
            $categories = Category::latest()->paginate(10);
        }
        return view('categories/index' , compact('categories', 'parentCategories'));
    }

    public function searchFromTrash(): View|Factory|Application
    {
        $keyword = request()->keyword;
        $parentCategories = Category::where('parent_id', '=', '0')->get();
        if (request()->has('keyword') && trim($keyword) != ''){
            $categories = Category::onlyTrashed()->where('title', 'LIKE', '%'.trim($keyword).'%')->latest()->paginate(10);
        }else{
            $categories = Category::onlyTrashed()->latest()->paginate(10);
        }
        return view('categories/trash' , compact('categories', 'parentCategories'));
    }

    public function trash(): View|Factory|Application
    {
        $categories = Category::onlyTrashed()->orderBy('status', 'desc')->paginate(10);
        $parentCategories = Category::where('parent_id', '=', '0')->get();
        return view('categories/trash', compact('categories', 'parentCategories'));
    }

    public function restore(Request $request): RedirectResponse
    {
        Category::onlyTrashed()->find($request->category)->restore();
        flash()->flash("success", 'دسته بندی مورد نظر با موفقیت بازگردانی شد!', [], 'موفقیت آمیز');
        return redirect()->back();
    }
}
