@extends('layout.master')

@php
    $active = 'editQuestion';
@endphp

@section('title')
سوالات: {{ $question->title }}
@endsection

@section('content')
<ol class="breadcrumb" style="direction: ltr;justify-content: right;">
    <li class="breadcrumb-item active">ویرایش سوال: {{ $question->title }}</li>
    <li class="breadcrumb-item"><a href="#">مدیریت</a>
    </li>
</ol>

<div class="container wrapper">
    <div class="row d-flex col-12">
        <div class="col-sm-12">
            <div class="card" style="text-align: start;">
                <form action="{{ route('surveys.update_question', ['question' => $question]) }}" method="post">
                    <input type="hidden" name="survey_id" value="{{ $question->survey_id }}">
                    @csrf
                    @method('put')
                    <div class="card-header">
                        <strong>ویرایش سوال: {{ $question->title }}</strong>
                    </div>
                    <div class="card-block d-flex row">
                        @include('layout.errors')
                        <div class="col-12">
                            <div class="form-group d-flex row ">
                                <label for="title" class="col-1 mr-5" style="align-self: end;" >عنوان:</label>
                                <input type="text" class="form-control col-9 mr-4" id="title" name="title" value="{{ $question->title }}" required>
                            </div>
                        </div>
                        @foreach($question->answers as $answer)
                            <div class="col-12">
                                <div class="form-group d-flex row col-12 justify-content-center">
                                    <input type="text" class="form-control col-10" name="answers[{{ $answer->id }}]" value="{{ $answer->title }}" required>
                                    <button class="btn btn-danger col-1 mx-1">حذف</button>
                                </div>
                            </div>
                        @endforeach
                            <div id="czContainer" class="col-12">
                                <div id="first" class="row">
                                    <div class="recordset d-flex">
                                        <span class="col-10 my-2">
                                            <label>پاسخ جدید: </label>
                                            <input type="text" name="newAnswers[]" class="form-control">
                                        </span>
                                    </div>
                                </div>
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
