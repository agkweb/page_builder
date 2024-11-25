@extends('layout.master')

@php
    $active = 'createQuiz';
@endphp

@section('title')
    آزمون ها: ایجاد آزمون جدید
@endsection

@section('content')
    <ol class="breadcrumb" style="direction: ltr;justify-content: right;">
        <li class="breadcrumb-item active">ثبت آزمون جدید</li>
        <li class="breadcrumb-item"><a href="#">مدیریت</a>
        </li>
    </ol>

    <div class="container wrapper">
        <div class="row d-flex col-12">
            <form method="POST" class="col-12" action="{{ route('quizzes.store') }}">
            @csrf
                <div class="col-sm-12">
                    <div class="card" style="text-align: start;">
                        <div class="card-header">
                            <strong>افزودن آزمون جدید</strong>
                        </div>
                        @include('layout.errors', ['errors' => $errors->createQuiz])
                        <div class="card-block d-flex row">
                            <div class="col-12 col-md-6">
                                <div class="form-group d-flex row ">
                                    <label for="title" class="col-3">عنوان:</label>
                                    <input type="text" class="form-control col-8" name="title" id="title" value="{{ old('title') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group d-flex row ">
                                    <label for="duration" class="col-3">مدت آزمون:</label>
                                    <input type="number" class="form-control col-8" name="duration" id="duration" value="{{ old('duration') }}">
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
                            <div class="col-12 col-md-12">
                                <div class="form-group d-flex row ">
                                    <label for="description" class="col-3">توضیحات:</label>
                                    <textarea class="form-control col-12" name="description" id="description">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div id="czContainer">
                                <div id="first">
                                    <div class="recordset">
                                        <div class="row">
                                            <span class="col-12 col-lg-12 my-2">
                                                <label for="question_title">نام سوال: *</label>
                                                <input id="question_title" type="text" name="questions[0][question]" class="form-control">
                                            </span>
                                            <span class="col-12 col-lg-3 my-2">
                                                <label>گزینه اول: گزینه صحیح</label>
                                                <input type="text" name="questions[0][answers][]correct" class="form-control" required>
                                            </span>
                                            <span class="col-12 col-lg-3 my-2">
                                                <label>گزینه دوم:* </label>
                                                <input type="text" name="questions[0][answers][]" class="form-control">
                                            </span>
                                            <span class="col-12 col-lg-3 my-2">
                                                <label>گزینه سوم:* </label>
                                                <input type="text" name="questions[0][answers][]" class="form-control">
                                            </span>
                                            <span class="col-12 col-lg-3 my-2">
                                                <label>گزینه چهارم:* </label>
                                                <input type="text" name="questions[0][answers][]" class="form-control">
                                            </span>
                                        </div>
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
@section('scripts')
    <script>
        $("#czContainer").czMore();
    </script>
@endsection
