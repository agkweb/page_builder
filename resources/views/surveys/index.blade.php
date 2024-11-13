@extends('layout.master')

@php
    $active = 'indexSurveys';
@endphp

@section('title')
پرسش نامه ها:
@endsection

@section('content')
<ol class="breadcrumb" style="direction: ltr;justify-content: right;">
    <li class="breadcrumb-item active">لیست پرسش نامه ها</li>
    <li class="breadcrumb-item"><a href="#">مدیریت</a>
    </li>
</ol>
<div class="wrapper container">
    <div class="d-flex row">
        <div class="col-6 mb-2" style="text-align: justify;">
            <button type="button" class="btn btn-primary mr-0" data-toggle="modal" data-target="#createSurveyModal">
                ایجاد پرسش نامه جدید
            </button>
            <a href="{{ route('surveys.trash') }}" class="btn btn-secondary " style="max-width: fit-content">
                <i class="fa fa-trash"></i>
                سطل آشغال
            </a>
        </div>
        <div class="col-6 my-0" style="justify-items: end;">
            <form class="ml-0 col-12 d-felx row justify-content-around" action="{{ route('surveys.search') }}" method="GET" id="filter">
                <label for="filter" class="col-2 px-0 pt-1" style="text-align-last: left; ">جستجو:</label>
                <input type="text" class="form-control col-3 ml-5" placeholder="جستجو بین پرسش نامه ها" value="{{ request()->has('keyword') ? request()->keyword : '' }}" name="keyword" id="search">
                <div class="form-group col-6  pr-0 d-flex row" style="text-align-last: start;">
                    <label for="filter" class="col-6 p-0" style="
    align-self: end;text-align-last: left; ">نمایش بر اساس: </label>
                    <select class="form-control col-5 mr-1" id="filter" name="filter" onchange="filterSearch()">
                        <option {{ request()->filter == '0' ? 'selected' : '' }} value="0">همه</option>
                        <option {{ request()->filter == '2' ? 'selected' : '' }} value="2">دارای فرم</option>
                        <option {{ request()->filter == '1' ? 'selected' : '' }} value="1">بدون فرم</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="modal fade" id="createSurveyModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="direction: rtl;">
                        <h5 class="modal-title" id="exampleModalLabel">ایجاد پرسش نامه:</h5>
                        <button type="button" class="close mr-auto ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-right">
                        <form action="{{ route('surveys.create') }}" method="GET">
                            @include('layout.errors', ['errors' => $errors->validatingBasicInfo])
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title">عنوان:</label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                                </div>
                            </div>
                            <div class="col-12" style="margin-top: 65px;">
                                <div class="form-group">
                                    <label class="col-md-3 form-control-label" for="select">فعال:</label>
                                    <div class="col-md-9">
                                        <select id="is_active" name="is_active" class="form-control input-lg">
                                            <option value="1" selected>فعال</option>
                                            <option value="0">غیرفعال</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">توضیحات:</label>
                                    <input type="text" class="form-control" name="description" id="description" value="{{ old('description') }}">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بازگشت</button>
                        <button type="submit" class="btn btn-primary">ادامه</button>
                    </div>
                    </form>
                </div>
            </div>
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
                @foreach($surveys as $key => $survey)
                    <tr>
                        <th scope="row">{{ $surveys->firstItem() + $key }}</th>
                        <td class="text-right">{{ $survey->title }}</td>
                        <td class="text-right">{{ $survey->status }}</td>
                        <td class="text-right">{{ $survey->is_active == 1 ? 'فعال' : 'غیرفعال' }}</td>
                        <td class="text-right">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown">
                                    تنظیمات
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('surveys.export', ['survey' => $survey]) }}">
                                        خروجی اکسل
                                    </a>
                                    <a class="dropdown-item" href="{{ route('surveys.show', ['survey' => $survey]) }}">
                                        نمایش
                                    </a>
                                    <a class="dropdown-item" href="{{ url('/surveysSearch?keyword=' . $survey->title ) }}">
                                        ثبت نامی ها
                                    </a>
                                    <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#editSurveyModal-{{ $survey->id }}">
                                        ویرایش
                                    </button>
                                    <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#deleteSurveyModal-{{ $survey->id }}">
                                        حذف
                                    </button>
                                </div>
                            </div>
                        </td>
                        <div class="modal fade" id="editSurveyModal-{{ $survey->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ویرایش پرسش نامه: {{ $survey->title }}</h5>
                                        <button type="button" class="close mr-auto ml-0" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-right">
                                        <form action="{{ route('surveys.edit', ['survey' => $survey]) }}" method="GET">
                                            @include('layout.errors', ['errors' => $errors->updateBasicInfo])
                                            <input type="hidden" class="form-control" name="survey_id" value="{{ $survey->id }}">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="title">عنوان:</label>
                                                    <input type="text" class="form-control" name="title" id="title" value="{{ $survey->title }}">
                                                </div>
                                            </div>
                                            <div class="col-12" style="margin-top: 65px;">
                                                <div class="form-group">
                                                    <label class="col-md-3 form-control-label" for="select">فعال:</label>
                                                    <div class="col-md-9">
                                                        <select id="is_active" name="is_active" class="form-control input-lg">
                                                            <option value="1" {{ $survey->is_active == 1 ? 'selected' : '' }}>فعال</option>
                                                            <option value="0" {{ $survey->is_active == 0 ? 'selected' : '' }}>غیرفعال</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="description">توضیحات:</label>
                                                    <input type="text" class="form-control" name="description" id="description" value="{{ $survey->description }}">
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بازگشت</button>
                                        <button type="submit" class="btn btn-primary">ویرایش</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="deleteModal-{{ $survey->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">حذف پرسش نامه: {{ $survey->title }}</h5>
                                        <button type="button" class="close mr-auto ml-0" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-right">
                                        آیا از حذف پرسش نامه مطمعن هستید؟
                                    </div>
                                    <form action="{{ route('surveys.destroy', ['survey' => $survey]) }}" method="POST">
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
        {{ $surveys->links('vendor.pagination.bootstrap-4')}}
    </div>
</div>
@endsection

@section('scripts')
<script>
    function filterSearch() {
        $('#filter').submit();
    }
</script>
@endsection
