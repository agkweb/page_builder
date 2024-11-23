@extends('layout.master')

@php
    $active = '';
@endphp

@section('title')
     پرسش نامه ها: حذف شده
@endsection

@section('content')
    <ol class="breadcrumb" style="direction: ltr;justify-content: right;">
        <li class="breadcrumb-item active">لیست پرسش نامه ها حذف شده</li>
        <li class="breadcrumb-item"><a href="#">مدیریت</a>
        </li>
    </ol>

    <div class="wrapper container text-center">
        <div class="d-flex row" >
            <div class="col-6 mb-2" style="text-align: justify;">
                <a href="{{ route('surveys.index') }}" class="btn btn-primary" style="max-width: fit-content">
                    <i class="fa fa-list-alt"></i>
                    پرسش نامه ها
                </a>
            </div>
            <div class="col-6 mb-2" style="justify-items: end;"><form class="ml-0" action="{{ route('surveys.searchFromTrash') }}" method="GET">
                    <input type="text" class="form-control" placeholder="جستجو بین پرسش نامه ها حذف شده" style="width: 250px" value="{{ request()->has('keyword') ? request()->keyword : '' }}" name="keyword">
                </form>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان</th>
                    <th scope="col">تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($surveys as $key => $survey)
                    <tr>
                        <th scope="row">{{ $surveys->firstItem() + $key }}</th>
                        <td class="text-right">{{ $survey->title }}</td>
                        <td class="text-right">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                    تنظیمات
                                </button>
                                <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item btn btn-primary" data-toggle="modal" data-target="#restoreSurveyModal-{{ $survey->id }}">
                                        بازگردانی
                                    </button>
                                </div>
                            </div>
                        </td>
                        <div class="modal fade" id="restoreSurveyModal-{{ $survey->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">بازگردانی پرسش نامه: {{ $survey->title }}</h5>
                                        <button type="button" class="close mr-auto ml-0" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-right">
                                        آیا از بازگردانی پرسش نامه مطمعن هستید؟
                                    </div>
                                    <form action="{{ route('surveys.restore', ['survey' => $survey]) }}" method="POST">
                                        <div class="modal-footer">
                                            @csrf
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بازگشت</button>
                                            <button type="submit" class="btn btn-primary">بازگردانی</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
@endsection
