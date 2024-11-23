@extends('layout.master')

@php
    $active = 'indexQuizzes';
@endphp

@section('title')
آزمون ها:
@endsection

@section('content')
<ol class="breadcrumb" style="direction: ltr;justify-content: right;">
    <li class="breadcrumb-item active">لیست آزمون ها</li>
    <li class="breadcrumb-item"><a href="#">مدیریت</a>
    </li>
</ol>
<div class="wrapper container">
    <div class="d-flex row">
        <div class="col-6 mb-2" style="text-align: justify;">
            <a href="{{ route('quizzes.create') }}" class="btn btn-primary mr-0">
                ایجاد آزمون جدید
            </a>
            <a href="{{ route('quizzes.trash') }}" class="btn btn-secondary " style="max-width: fit-content">
                <i class="fa fa-trash"></i>
                سطل آشغال
            </a>
        </div>
        <div class="col-6 my-0" style="justify-items: end;">
            <form class="ml-0 col-12 d-felx row justify-content-around" action="{{ route('quizzes.search') }}" method="GET" id="filter">
                <label for="filter" class="col-2 px-0 pt-1" style="text-align-last: left; ">جستجو:</label>
                <input type="text" class="form-control col-3 ml-5" placeholder="جستجو بین آزمون ها" value="{{ request()->has('keyword') ? request()->keyword : '' }}" name="keyword" id="search">
{{--                <div class="form-group col-6  pr-0 d-flex row" style="text-align-last: start;">--}}
{{--                    <label for="filter" class="col-6 p-0" style="align-self: end;text-align-last: left; ">نمایش بر اساس: </label>--}}
{{--                    <select class="form-control col-5 mr-1" id="filter" name="filter" onchange="filterSearch()">--}}
{{--                        <option {{ request()->filter == '0' ? 'selected' : '' }} value="0">همه</option>--}}
{{--                        <option {{ request()->filter == '2' ? 'selected' : '' }} value="2">دارای فرم</option>--}}
{{--                        <option {{ request()->filter == '1' ? 'selected' : '' }} value="1">بدون فرم</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
            </form>
        </div>

        <table class="table col-12">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان</th>
                    <th scope="col">وضعیت</th>
                    <th scope="col">فعال</th>
                    <th scope="col">تنظیمات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quizzes as $key => $quiz)
                    <tr>
                        <th scope="row">{{ $quizzes->firstItem() + $key }}</th>
                        <td class="text-right">{{ $quiz->title }}</td>
                        <td class="text-right">{{ $quiz->status }}</td>
                        <td class="text-right">{{ $quiz->is_active == 1 ? 'فعال' : 'غیرفعال' }}</td>
                        <td class="text-right">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown">
                                    تنظیمات
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('quizzes.export', ['quiz' => $quiz]) }}">
                                        خروجی اکسل
                                    </a>
                                    <a class="dropdown-item" href="{{ route('quizzes.show', ['quiz' => $quiz]) }}">
                                        نمایش
                                    </a>
                                    <a class="dropdown-item" href="{{ route('quizzes.preview', ['quiz' => $quiz->slug]) }}">
                                        پیش نمایش
                                    </a>
                                    <a class="dropdown-item" href="{{ route('quizzes.edit', ['quiz' => $quiz]) }}">
                                        ویرایش
                                    </a>
                                    <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#deleteQuizModal-{{ $quiz->id }}">
                                        حذف
                                    </button>
                                </div>
                            </div>
                        </td>
                        <div class="modal fade" id="deleteQuizModal-{{ $quiz->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">حذف آزمون: {{ $quiz->title }}</h5>
                                        <button type="button" class="close mr-auto ml-0" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-right">
                                        آیا از حذف آزمون مطمعن هستید؟
                                    </div>
                                    <form action="{{ route('quizzes.destroy', ['quiz' => $quiz]) }}" method="POST">
                                        <div class="modal-footer">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">بازگشت</button>
                                            <button type="submit" class="btn btn-primary">حذف</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $quizzes->links('vendor.pagination.bootstrap-4')}}
    </div>
</div>
@endsection
