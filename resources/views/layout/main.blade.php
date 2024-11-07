@extends('layout.master')

@php
    $active = 'dashboard';
@endphp

@section('title')
    صفحه اصلی: (داشبورد)
@endsection

@section('content')
    <ol class="breadcrumb" style="direction: ltr;justify-content: right;">
        <li class="breadcrumb-item active">داشبورد</li>
        <li class="breadcrumb-item"><a href="#">مدیریت</a>
        </li>
    </ol>
    <div class="wrapper container">

    </div>
@endsection
