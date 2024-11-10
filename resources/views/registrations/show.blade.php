@extends('layout.master')

@php
    $active = '';
@endphp

@section('title')
    ثبت نامی ها: {{ $registeration->phone_number }}
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">خانه</li>
        <li class="breadcrumb-item"><a href="#">مدیریت</a>
        </li>
        <li class="breadcrumb-item active">نمایش ثبت نامی: {{ $registeration->phone_number }}</li>
    </ol>

    <div class="container text-right">
        <div class="row">
            <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>نمایش ثبت نامی: {{ $registeration->phone_number }}</strong>
                        </div>
                        <div class="card-block d-flex row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="fullname">نام و نام خانوادگی:</label>
                                    <input type="text" class="form-control" id="fullname" value="{{ $registeration->fullname }}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="status" class="form-label">وضعیت:</label>
                                    <input type="number" class="form-control" id="status" value="{{ $category->status }}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 form-control-label" for="select">دسته بندی:</label>
                                    <div class="col-md-9">
                                        <select id="parent_id" class="form-control input-lg" disabled>
                                            <option selected>{{ $category->parent_id != 0 ? $category->parent->title : 'والد' }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 form-control-label" for="select">فعال:</label>
                                        <div class="col-md-9">
                                            <select id="is_active" name="is_active" class="form-control input-lg" disabled>
                                                <option {{ $category->is_active == 1 ? 'selected' : '' }}>فعال</option>
                                                <option {{ $category->is_active == 0 ? 'selected' : '' }}>غیرفعال</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('categories.index') }}" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i>برگشت</a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
