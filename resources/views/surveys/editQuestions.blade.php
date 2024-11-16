@extends('layout.master')

@php
    $active = 'editSurvey';
@endphp

@section('title')
    ویرایش سوالات: {{ $survey->title }}
@endsection

@section('content')
    <ol class="breadcrumb" style="direction: ltr;justify-content: right;">
        <li class="breadcrumb-item active">ویرایش سوالات: {{ $survey->title }}</li>
        <li class="breadcrumb-item"><a href="#">مدیریت</a>
        </li>
    </ol>

    <div class="container wrapper">
        <div class="row d-flex col-12">
            <div class="col-sm-12">
                <div class="card" style="text-align: start;">
                    <div class="card-header">
                        <strong>ویرایش سوالات: {{ $survey->title }}</strong>
                    </div>
                    <div class="card-block d-flex row">
                        @foreach($survey->questions as $question)
                            <div class="row">
                                <span class="col-12 col-lg-12 my-2">
                                    <label for="question_title">نام سوال: *</label>
                                    <input id="question_title" type="text" name="questions[{{ $question->id }}][question]" class="form-control" value="{{ $question->title }}">
                                </span>
                                @foreach($question->answers as $answer)
                                    <span class="col-12 col-lg-3 my-2">
                                        <label>گزینه: *</label>
                                        <input type="text" name="questions[{{ $question->id }}][answers][{{ $answer->id }}]" class="form-control" value="{{ $answer->title }}">
                                    </span>
                                @endforeach
                                <div id="newAnswer">
                                    <div id="first">
                                        <div class="recordset">
                                            <span class="col-12 col-lg-3 my-2">
                                                <label>گزینه: *</label>
                                                <input type="text" name="questions[{{ $question->id }}][answers][]" class="form-control" style="width: 220px">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
@section('scripts')
    <script>
        $("#newAnswer").czMore();
    </script>
@endsection
