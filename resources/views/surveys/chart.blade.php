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
    <div class="container-fluid row d-flex">
        @foreach ($data as $questionData)
            <div class="col-6">
                <h4 class="text-right rtl">
                    {{ $questionData['question'] }}
                </h4>
                <canvas id="chart-{{ $questionData['question'] }}">

                </canvas>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
        const chartData = @json($data);

        chartData.forEach(questionData => {
            const ctx = document.getElementById(`chart-${questionData.question}`).getContext('2d');
            const labels = questionData.answers.map(item => item.answer);
            const responses = questionData.answers.map(item => item.responses);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'پاسخ ها #',
                        data: responses,
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
        });

        function printChart() {
            window.print();
        }
    </script>
@endsection

