@extends('layout.master')

@php
    $active = 'editSurvey';
@endphp

@section('title')
    پرسش نامه ها: {{ $survey->title }}
@endsection

@section('content')
    <ol class="breadcrumb" style="direction: ltr;justify-content: right;">
        <li class="breadcrumb-item active">نمایش پرسش نامه: {{ $survey->title }}</li>
        <li class="breadcrumb-item"><a href="#">مدیریت</a>
        </li>
    </ol>

    <div class="container wrapper">
        <div class="row d-flex col-12">
            <div class="col-sm-12">
                <div class="card" style="text-align: start;">
                    <div class="card-header">
                        <strong>نمایش پرسش نامه: {{ $survey->title }}</strong>
                    </div>
                    <div class="card-block d-flex row">
                        <div class="col-12 col-md-6">
                            <div class="form-group d-flex row ">
                                <label for="title" class="col-3">عنوان:</label>
                                <input type="text" class="form-control col-8" id="title" value="{{ $survey->title }}" disabled>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 form-control-label px-0 pt-1" for="select">فعال:</label>
                                <div class="col-md-9">
                                    <select id="is_active" name="is_active" class="form-control input-lg" disabled>
                                        <option {{ $survey->is_active == 1 ? 'selected' : '' }}>فعال</option>
                                        <option {{ $survey->is_active == 0 ? 'selected' : '' }}>غیرفعال</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group d-flex row ">
                                <label for="description" class="col-3">توضیحات:</label>
                                <textarea class="form-control col-12" name="description" id="description" disabled>
                                    {{ $survey->description }}
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> ثبت</button>
                        <a href="{{ route('surveys.index') }}" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> بازگشت</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
