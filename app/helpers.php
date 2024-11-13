<?php

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

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

function convertToGregorianDate($date): ?string
{
    if ($date == null){
        return null;
    }
    $pattern = "#[/\s]#";
    $splitedSolarDate = preg_split($pattern, $date);
    $gregorianFormat = Verta::jalaliToGregorian($splitedSolarDate[0],$splitedSolarDate[1],$splitedSolarDate[2]);
    return implode("/" , $gregorianFormat) . " " . $splitedSolarDate[3];
}
