@extends('layout.master')

@php
    $active = 'showChart';
@endphp

@section('content')
    <style>
        @media print {
            #printBtn {
                display: none;
            }
        }
    </style>
    <button id="printBtn" class="btn btn-primary text-right m-2" style="float: right" onclick="printChart()">پرینت نمودار ها</button>
    <div class="container-fluid row">
        <div class="w-50">
            <h4 class="text-right rtl">ثبت نامی ها:</h4>
            <canvas id="registrations"></canvas>
        </div>
        <div class="w-50">
            <h4 class="text-right rtl">بازدید ها:</h4>
            <canvas id="visits"></canvas>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const formTitles = @json($forms->pluck('title')->toArray());
        const formRegistrationCounts = @json($forms->pluck('registrations_count')->toArray());
        const formVisitsCounts = @json($forms->pluck('visits')->toArray());
        const registrations = document.getElementById('registrations');
        const visits = document.getElementById('visits');

        new Chart(registrations, {
            type: 'bar',
            data: {
                labels: formTitles,
                datasets: [{
                    label: 'ثبت نامی #',
                    data: formRegistrationCounts,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(visits, {
            type: 'bar',
            data: {
                labels: formTitles,
                datasets: [{
                    label: 'بازدید #',
                    data: formVisitsCounts,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        function printChart() {
            window.print();
        }
    </script>
@endsection
