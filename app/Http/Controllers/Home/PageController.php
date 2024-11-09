<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Factory|Application
    {
        $pages = Page::with('category')->latest()->paginate(10);
        $categories = Category::active()->get();
        return view('pages/index', compact('pages', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Factory|View|Application
    {
        $request->validateWithBag('validatingBasicInfo', [
            'title' => 'required',
            'category_id' => 'required',
            'is_active' => 'required|string',
            'status' => 'required'
        ]);

        $data = $request->all();

        return view('pages.make', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validateWithBag('createPage', [
            'title' => 'required',
            'category_id' => 'required',
            'html' => 'required|string',
            'css' => 'required|string',
            'status' => 'required',
            'is_active' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $hasForm = containsForm($request->html);

            Page::create([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'user_id' => '1',
                'html' => $request->html,
                'css' => $request->css,
                'status' => $hasForm ? 2 : 1,
                'is_active' => $request->is_active,
            ]);

            DB::commit();
        }catch (Exception $ex) {
            DB::rollBack();
            flash()->flash("error", $ex->getMessage(), [], 'مشکلی پیش آمد');
        }

        flash()->flash("success", 'با موفقیت به صفحات اضافه شد.', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page): View|Factory|Application
    {
        $page->increment('visits');
        return view('pages/show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Page $page)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category_id' => 'required',
            'is_active' => 'required|string',
            'status' => 'required'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator, 'updateBasicInfo')->withInput()->with(['page_id' => $page->id]);
        }else{
            $page = Page::findOrFail($request->page_id);
            $page->update([
               'title' => $request->title,
               'category_id' => $request->category_id,
               'is_active' => $request->is_active,
               'status' => $request->status
            ]);
            return view('pages.update', compact('page'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'category_id' => 'required',
            'html' => 'required|string',
            'css' => 'required|string'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator, 'updatePage')->withInput()->with(['page_id' => $page->id]);
        }

        try {
            DB::beginTransaction();

            $page->update([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'user_id' => '1',
                'html' => $request->html,
                'css' => $request->css
            ]);

            DB::commit();
        }catch (Exception $ex) {
            DB::rollBack();
            flash()->flash("error", $ex->getMessage(), [], 'مشکلی پیش آمد');
            return redirect()->back();
        }

        flash()->flash("success", 'صفحه مورد نظر با موفقیت ویرایش شد!', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();
        flash()->flash("success", 'صفحه مورد نظر با موفقیت حذف شد!', [], 'موفقیت آمیز');
        return redirect()->back();
    }

    public function search(): Factory|View|Application
    {
        $keyword = request()->keyword;
        $filter = request()->filter;
        $categories = Category::active()->get();
        if (request()->has('keyword') && trim($keyword) != ''){
            $pages = Page::where('title', 'LIKE', '%'.trim($keyword).'%')->where('status', '=', $filter)->latest()->paginate(10);
        }elseif(request()->has('keyword') && trim($keyword) != ''){
            $pages = Page::where('title', 'LIKE', '%'.trim($keyword).'%')->where('status', '=', $filter)->latest()->paginate(10);
        }{
            $pages = Page::latest()->paginate(10);
        }
        return view('pages/index' , compact('pages', 'categories'));
    }

    public function searchFromTrash(): View|Factory|Application
    {
        $keyword = request()->keyword;
        $categories = Category::active()->get();
        if (request()->has('keyword') && trim($keyword) != ''){
            $pages = Page::onlyTrashed()->where('title', 'LIKE', '%'.trim($keyword).'%')->latest()->paginate(10);
        }else{
            $pages = Page::onlyTrashed()->latest()->paginate(10);
        }
        return view('pages/trash' , compact('pages', 'categories'));
    }

    public function trash(): View|Factory|Application
    {
        $pages = Page::onlyTrashed()->orderBy('status', 'desc')->paginate(10);
        $categories = Category::active()->get();
        return view('pages/trash', compact('pages', 'categories'));
    }

    public function restore(Request $request): RedirectResponse
    {
        Page::onlyTrashed()->find($request->page)->restore();
        flash()->flash("success", 'صفحه مورد نظر با موفقیت بازگردانی شد!', [], 'موفقیت آمیز');
        return redirect()->back();
    }
}
