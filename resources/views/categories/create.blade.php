@extends('layout.master')

@php
    $active = 'createCategory';
@endphp

@section('title')
    دسته بندی ها:
@endsection

@section('content')
    <ol class="breadcrumb" style="direction: ltr;justify-content: right;">
        <li class="breadcrumb-item active">ثبت دسته بندی جدید</li>
        <li class="breadcrumb-item"><a href="#">مدیریت</a>
        </li>
    </ol>

    <div class="container wrapper">
        <div class="row d-flex col-12">
            <form method="POST" class="col-12" action="{{ route('categories.store') }}">
            @csrf
                <div class="col-sm-12">
                    <div class="card"style="text-align: start;">
                        <div class="card-header">
                            <strong>افزودن دسته بندی جدید</strong>
                        </div>
                        @include('layout.errors', ['errors' => $errors->createCategory])
                        <div class="card-block d-flex row">
                            <div class="col-12 col-md-6">
                                <div class="form-group d-flex row ">
                                    <label for="title" class="col-3">عنوان:</label>
                                    <input type="text" class="form-control col-8" name="title" id="title" value="{{ old('title') }}">
                                </div>
                            </div>
{{--                            <div class="col-12 col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="status" class="form-label">وضعیت:</label>--}}
{{--                                    <input type="number" name="status" class="form-control" id="status" value="{{ old('status') }}">--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 form-control-label px-0 pt-1" for="select">دسته بندی:</label>
                                    <div class="col-md-9">
                                        <select id="parent_id" name="parent_id" class="form-control input-lg">
                                            <option value="0">والد</option>
                                            @foreach($parentCategories as $parentCategory)
                                                <option value="{{ $parentCategory->id }}">{{ $parentCategory->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 form-control-label px-0 pt-1" for="select">فعال:</label>
                                    <div class="col-md-9">
                                        <select id="is_active" name="is_active" class="form-control input-lg">
                                            <option value="1" selected>فعال</option>
                                            <option value="0">غیرفعال</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> ثبت</button>
                            <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> بازنشانی</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
