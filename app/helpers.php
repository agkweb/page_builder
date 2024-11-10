<?php

use Carbon\Carbon;

function generateFileName($name): string
{
    $year = Carbon::now()->year;
    $month = Carbon::now()->month;
    $day = Carbon::now()->day;
    $hour = Carbon::now()->hour;
    $minute = Carbon::now()->minute;
    $second = Carbon::now()->second;
    $microsecond = Carbon::now()->microsecond;
    return $year .'_'. $month .'_'. $day .'_'. $hour .'_'. $minute .'_'. $second .'_'. $microsecond .'_'. strtolower($name);
}
function containsForm($htmlContent): bool
{
    $dom = new DOMDocument();
    @$dom->loadHTML($htmlContent);
    $forms = $dom->getElementsByTagName('form');
    return $forms->length > 0;
}
