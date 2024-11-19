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
                <form action="{{ route('questions.update_questions', ['question' => $question]) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="card-header">
                        <strong>ویرایش سوال: {{ $question->title }}</strong>
                    </div>
                    <div class="card-block d-flex row">
                        @include('layout.errors')
                        <div class="col-12 col-md-6">
                            <div class="form-group d-flex row ">
                                <label for="title" class="col-3">عنوان:</label>
                                <input type="text" class="form-control col-8" id="title" name="title" value="{{ $question->title }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 form-control-label px-0 pt-1" for="select">فعال:</label>
                                <div class="col-md-9">
                                    <select id="is_active" name="is_active" class="form-control input-lg">
                                        <option {{ $question->is_active == 1 ? 'selected' : '' }} value="1">فعال</option>
                                        <option {{ $question->is_active == 0 ? 'selected' : '' }} value="0">غیرفعال</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group d-flex row ">
                                <label for="description" class="col-3">توضیحات:</label>
                                <textarea class="form-control col-12" name="description"
                                    id="description">{{ $question->description }}</textarea>
                            </div>
                        </div>

                        <div id="czContainer">
                            <div id="first">
                                <div class="recordset">
                                    <span class="col-12 col-lg-3 my-2">
                                        <label>گزینه اول: *</label>
                                        <input type="text" name="questions[0][answers][]" class="form-control" required>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> ثبت</button>
                        <a href="{{ route('questions.index') }}" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> بازگشت</a>
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
