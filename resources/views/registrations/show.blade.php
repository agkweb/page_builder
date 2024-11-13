@extends('layout.master')

@php
    $active = '';
@endphp

@section('title')
    ثبت نامی ها: {{ $registration->phone_number }}
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">خانه</li>
        <li class="breadcrumb-item"><a href="#">مدیریت</a>
        </li>
        <li class="breadcrumb-item active">نمایش ثبت نامی: {{ $registration->phone_number }}</li>
    </ol>

    <div class="container text-right">
        <div class="row">
            <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>نمایش ثبت نامی: {{ $registration->phone_number }}</strong>
                        </div>
                        <div class="card-block d-flex row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="fullname">نام و نام خانوادگی:</label>
                                    <input type="text" class="form-control" id="fullname" value="{{ $registration->fullname ? $registration->fullname : '' }}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="phone_number" class="form-label">شماره تلفن:</label>
                                    <input type="number" class="form-control" id="phone_number" value="{{ $registration->phone_number }}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="email">ایمیل:</label>
                                    <input type="email" class="form-control" id="email" value="{{ $registration->email ? $registration->email : '' }}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="license">مدرک:</label>
                                    <input type="text" class="form-control" id="license" value="{{ $registration->license ? $registration->license : '' }}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="university">دانشگاه:</label>
                                    <input type="text" class="form-control" id="university" value="{{ $registration->university_name ? $registration->university_name : '' }}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="province">استان:</label>
                                    <input type="text" class="form-control" id="province" value="{{ $registration->province ? $registration->province : '' }}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="city">شهر:</label>
                                    <input type="text" class="form-control" id="city" value="{{ $registration->city ? $registration->city->name : '' }}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="created_at">تاریخ ثبت نام:</label>
                                    <input type="text" class="form-control" id="created_at" value="{{ verta($registration->created_at) }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('registrations.index') }}" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i>برگشت</a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
