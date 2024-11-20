@extends('layout.master')

@php
    $active = 'indexSurveys';
@endphp

@section('title')
پرسش نامه ها: خروجی اکسل
@endsection

@section('content')
<ol class="breadcrumb" style="direction: ltr;justify-content: right;">
    <li class="breadcrumb-item active">خروجی اکسل</li>
    <li class="breadcrumb-item"><a href="#">مدیریت</a>
    </li>
</ol>
<div class="wrapper container">
    <div class="d-flex row justify-content-center">
        <div class="col-9 mb-2 mr-4" style="text-align: justify;">
            <a href="{{ route('surveys.index') }}" class="btn btn-primary mr-0">
                پرسش نامه ها
            </a>
        </div>
        <form class="col-9 justify-content-center" method="POST" action="{{ route('surveys.exportInExcel', ['survey' => $survey]) }}">
            @csrf
            <div class="col-12">
                <div class="card text-end d-flex">
                    <div class="card-header" style="text-align: right;">
                        <strong>خروجی پرسش نامه: {{ $survey->title }}</strong>
                    </div>
                    @include('layout.errors')
                    <div class="card-block d-flex row" style="text-align: right">
                        <div class="col-12 col-md-6">
                            <div class="form-group row">
                                <label for="title" class="col-3" style="align-self: self-end;">از تاریخ: </label>
                                <input data-jdp type="text" class="form-control col-8" name="start" id="start" value="{{ old('start') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group row">
                                <label for="title" class="col-3" style="align-self: self-end;">تا تاریخ: </label>
                                <input data-jdp type="text" class="form-control col-8" name="end" id="end" value="{{ old('end') }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i>خروجی</button>
                        <a href="{{ route('surveys.index') }}" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> برگشت</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        jalaliDatepicker.startWatch({ time: true });
    </script>
@endsection
