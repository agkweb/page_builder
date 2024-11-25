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
            <h4 class="text-right rtl">پاسخ ها:</h4>
            <canvas id="responses"></canvas>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const questionAnswers = @json($data->pluck('answer'));
        const questionResponses = @json($data->pluck('responses'));
        const responses = document.getElementById('responses').getContext('2d');
        new Chart(responses, {
            type: 'bar',
            data: {
                labels: questionAnswers,
                datasets: [{
                    label: 'پاسخ ها #',
                    data: questionResponses, borderWidth: 1
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
