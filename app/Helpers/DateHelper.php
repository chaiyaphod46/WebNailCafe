<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function formatThaiDate($date)
    {
        $months = [
            '01' => 'มกราคม',
            '02' => 'กุมภาพันธ์',
            '03' => 'มีนาคม',
            '04' => 'เมษายน',
            '05' => 'พฤษภาคม',
            '06' => 'มิถุนายน',
            '07' => 'กรกฎาคม',
            '08' => 'สิงหาคม',
            '09' => 'กันยายน',
            '10' => 'ตุลาคม',
            '11' => 'พฤศจิกายน',
            '12' => 'ธันวาคม',
        ];

        $carbonDate = Carbon::parse($date);
        $year = $carbonDate->year + 543; // เปลี่ยนเป็นปีพุทธศักราช
        $month = $carbonDate->format('m');
        $day = $carbonDate->format('d');

        return "$day {$months[$month]} $year";
    }
}
