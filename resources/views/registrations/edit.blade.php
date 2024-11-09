@extends('layout.master')

@php
    $active = '';
@endphp

@section('title')
    دسته بندی ها: {{ $category->title }}
@endsection

@section('content')
    <ol class="breadcrumb" style="direction: ltr;justify-content: right;">
        <li class="breadcrumb-item active">ویرایش دسته بندی: {{ $category->title }}</li>
        <li class="breadcrumb-item"><a href="#">مدیریت</a>
        </li>
    </ol>

    <div class="container wrapper">
        <div class="row">
            <form method="POST" action="{{ route('categories.update', ['category' => $category]) }}">
                @method('put')
                @csrf
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>افزودن دسته بندی جدید</strong>
                        </div>
                        @include('layout.errors', ['errors' => $errors->updateCategory])
                        <div class="card-block d-flex row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="title">عنوان</label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{ $category->title }}">
                                </div>
                            </div>
{{--                            <div class="col-12 col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="status" class="form-label">وضعیت:</label>--}}
{{--                                    <input type="number" name="status" class="form-control" id="status" value="{{ $category->status }}">--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 form-control-label" for="select">دسته بندی:</label>
                                    <div class="col-md-9">
                                        <select id="parent_id" name="parent_id" class="form-control input-lg">
                                            <option value="0">والد</option>
                                            @foreach($parentCategories as $parentCategory)
                                                <option value="{{ $parentCategory->id }}" {{ $category->parent_id == $parentCategory->id ? 'selected' : '' }}>{{ $parentCategory->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 form-control-label" for="select">فعال:</label>
                                        <div class="col-md-9">
                                            <select id="is_active" name="is_active" class="form-control input-lg">
                                                <option value="1" {{ $category->is_active == 1 ? 'selected' : '' }}>فعال</option>
                                                <option value="0" {{ $category->is_active == 0 ? 'selected' : '' }}>غیرفعال</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> ویرایش</button>
                            <a href="{{ route('categories.index') }}" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> برگشت</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
