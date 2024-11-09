@extends('layout.master')

@php
    $active = 'indexCategory';
@endphp

@section('title')
    دسته بندی ها:
@endsection

@section('content')
    <ol class="breadcrumb" style="direction: ltr;justify-content: right;">
        <li class="breadcrumb-item active">لیست دسته بندی ها</li>
        <li class="breadcrumb-item"><a href="#">مدیریت</a>
        </li>
    </ol>
    <div class="wrapper container">
        <div class="d-flex row">
             <div class="col-6 mb-2" style="text-align: justify;">
                 <a class="btn btn-primary mr-0" href="{{ route('categories.create') }}">
                 ایجاد دسته بندی جدید
                </a>
                 <a href="{{ route('categories.trash') }}" class="btn btn-secondary " style="max-width: fit-content">
                     <i class="fa fa-trash"></i>
                     سطل آشغال
                 </a>
             </div>
            <div class="col-6 mb-2" style="justify-items: end;">
                <form class="ml-0" action="{{ route('categories.search') }}" method="GET">
                    <input type="text" class="form-control" placeholder="جستجو بین دسته بندی ها" style="width: 250px" value="{{ request()->has('keyword') ? request()->keyword : '' }}" name="keyword">
                </form>
            </div>

            <table class="table col-12">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان</th>
                    <th scope="col">سرپرست</th>
                    <th scope="col">وضعیت</th>
                    <th scope="col">تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $key => $category)
                    <tr>
                        <th>{{ $categories->firstItem() + $key }}</th>
                        <td class="text-right">{{ $category->title }}</td>
                        <td class="text-right">{{ $category->parent_id == 0 ? 'والد' : 'فرزند' . '-' . $category->parent->title }}</td>
                        <td class="text-right">{{ $category->is_active == 1 ? 'فعال' : 'غیرفعال' }}</td>
                        <td class="text-right">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                    تنظیمات
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('categories.show', ['category' => $category]) }}">
                                        نمایش
                                    </a>
                                    <a class="dropdown-item" href="{{ route('categories.edit', ['category' => $category]) }}">
                                        ویرایش
                                    </a>
                                    <button type="button" class="dropdown-item" data-toggle="modal" data-target="#deleteCategoryModal-{{ $category->id }}">
                                        حذف
                                    </button>
                                </div>
                            </div>
                        </td>
                        <div class="modal fade" id="deleteCategoryModal-{{ $category->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">حذف دسته بندی: {{ $category->title }}</h5>
                                        <button type="button" class="close mr-auto ml-0" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-right">
                                        آیا از حذف دسته بندی مطمعن هستید؟
                                    </div>
                                    <form action="{{ route('categories.destroy', ['category' => $category]) }}" method="POST">
                                        <div class="modal-footer">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بازگشت</button>
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
            {{ $categories->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>

@endsection
