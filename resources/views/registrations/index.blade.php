@extends('layout.master')

@php
    $active = 'indexRegistrations';
@endphp

@section('title')
    ثبت نامی ها:
@endsection

@section('content')
    <ol class="breadcrumb" style="direction: ltr;justify-content: right;">
        <li class="breadcrumb-item active">لیست ثبت نامی ها</li>
        <li class="breadcrumb-item"><a href="#">مدیریت</a>
        </li>
    </ol>
    <div class="wrapper container">
        <div class="d-flex row" style="flex-direction: row-reverse;" >
            <div class="col-6 mb-2" style="justify-items: end;">
                <form class="ml-0" action="{{ route('registrations.search') }}" method="GET">
                    <input type="text" class="form-control" placeholder="جستجو بین ثبت نامی ها با نام صفحه" style="width: 250px" value="{{ request()->has('keyword') ? request()->keyword : '' }}" name="keyword">
                </form>
            </div>

            <table class="table col-12">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">فرم مربوطه</th>
                    <th scope="col">شماره تلفن</th>
                    <th scope="col">تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($registrations as $key => $registration)
                    <tr>
                        <th>{{ $registrations->firstItem() + $key }}</th>
                        <td class="text-right">{{ $registration->page->title }}</td>
                        <td class="text-right">{{ $registration->phone_number }}</td>
                        <td class="text-right">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                    تنظیمات
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('registrations.show', ['registration' => $registration]) }}">
                                        نمایش
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $registrations->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection
