@extends('layout.master')

@php
    $active = 'indexPages';
@endphp

@section('title')
صفحات: خروجی اکسل
@endsection

@section('content')
<ol class="breadcrumb" style="direction: ltr;justify-content: right;">
    <li class="breadcrumb-item active">خروجی اکسل</li>
    <li class="breadcrumb-item"><a href="#">مدیریت</a>
    </li>
</ol>
<div class="wrapper container">
    <div class="d-flex row">
        <div class="col-6 mb-2" style="text-align: justify;">
            <a href="{{ route('pages.index') }}" class="btn btn-primary mr-0">
                صفحات
            </a>
        </div>
        <form method="POST" action="{{ route('pages.exportInExcel', ['page' => $page]) }}">
            @csrf
            <div class="col-sm-12">
                <div class="card text-end">
                    <div class="card-header" style="text-align: right;">
                        <strong>خروجی صفحه: {{ $page->title }}</strong>
                    </div>
                    @include('layout.errors')
                    <div class="card-block d-flex row" style="
    text-align: right">
                        <div class="col-12 col-md-6">
                            <div class="form-group row">
                                <label for="title" class="col-3">از تاریخ: </label>
                                <input data-jdp type="text" class="form-control col-8" name="start" id="start" value="{{ old('start') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group row">
                                <label for="title" class="col-3">تا تاریخ: </label>
                                <input data-jdp type="text" class="form-control col-8" name="end" id="end" value="{{ old('end') }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i>خروجی</button>
                        <a href="{{ route('pages.index') }}" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> برگشت</a>
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
