@extends('layout.master')

@php
    $active = 'editSurvey';
@endphp

@section('title')
پرسش نامه ها: {{ $survey->title }}
@endsection

@section('content')
<ol class="breadcrumb" style="direction: ltr;justify-content: right;">
    <li class="breadcrumb-item active">ویرایش پرسش نامه: {{ $survey->title }}</li>
    <li class="breadcrumb-item"><a href="#">مدیریت</a>
    </li>
</ol>

<div class="container wrapper">
    <div class="row d-flex col-12">
        <div class="col-sm-12">
            <div class="card" style="text-align: start;">
                <form action="{{ route('surveys.update', ['survey' => $survey]) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="card-header">
                        <strong>ویرایش پرسش نامه: {{ $survey->title }}</strong>
                    </div>
                    <div class="card-block d-flex row">
                        @include('layout.errors')
                        <div class="col-12 col-md-6">
                            <div class="form-group d-flex row ">
                                <label for="title" class="col-3">عنوان:</label>
                                <input type="text" class="form-control col-8" id="title" name="title" value="{{ $survey->title }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 form-control-label px-0 pt-1" for="select">فعال:</label>
                                <div class="col-md-9">
                                    <select id="is_active" name="is_active" class="form-control input-lg">
                                        <option {{ $survey->is_active == 1 ? 'selected' : '' }} value="1">فعال</option>
                                        <option {{ $survey->is_active == 0 ? 'selected' : '' }} value="0">غیرفعال</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group d-flex row ">
                                <label for="description" class="col-3">توضیحات:</label>
                                <textarea class="form-control col-12" name="description"
                                    id="description">{{ $survey->description }}</textarea>
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
                                            <label>گزینه اول: *</label>
                                            <input type="text" name="questions[0][answers][]" class="form-control" required>
                                        </span>
                                        <span class="col-12 col-lg-3 my-2">
                                            <label>گزینه دوم: </label>
                                            <input type="text" name="questions[0][answers][]" class="form-control">
                                        </span>
                                        <span class="col-12 col-lg-3 my-2">
                                            <label>گزینه سوم: </label>
                                            <input type="text" name="questions[0][answers][]" class="form-control">
                                        </span>
                                        <span class="col-12 col-lg-3 my-2">
                                            <label>گزینه چهارم: </label>
                                            <input type="text" name="questions[0][answers][]" class="form-control">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row d-flex justify-content-start">
                            <label for="questions" class="col-12">سوالات:</label>
                            @foreach($survey->questions as $question)
                                <div class="col-12 my-1 row d-flex justify-content-start" id="questions">
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ $question->title }}
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <a class="dropdown-item" href="{{ route('surveys.edit_question', ['question' => $question]) }}">ویرایش</a>
                                            <a href="{{ route('surveys.delete_question', ['question' => $question]) }}" class="dropdown-item" >حذف</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> ثبت</button>
                        <a href="{{ route('surveys.index') }}" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $("#czContainer").czMore();
    </script>
@endsection
