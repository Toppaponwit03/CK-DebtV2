<?php
namespace App\datethai;

use Carbon\Carbon;

class thaidate
{
    // public static function simpleDateFormat($arg)
    // {
    //         if($arg != '' && $arg != '0000-00-00'){
    //         $thai_months = [
    //             1 => 'ม.ค.',
    //             2 => 'ก.พ.',
    //             3 => 'มี.ค.',
    //             4 => 'เม.ย.',
    //             5 => 'พ.ค.',
    //             6 => 'มิ.ย.',
    //             7 => 'ก.ค.',
    //             8 => 'ส.ค.',
    //             9 => 'ก.ย.',
    //             10 => 'ต.ค.',
    //             11 => 'พ.ย.',
    //             12 => 'ธ.ค.',
    //         ];
    //         $date = Carbon::parse($arg);
    //         $month = $thai_months[$date->month];
    //         $year = $date->year + 543;
    //         return $date->format("j/$month");
    //     }
    //     else{
    //         return "-";
    //     }
    //     //return $date->format("j $month $year H:i:s");
    // }

    public static function simpleDateFormatFull($arg)
    {
            if($arg != '' && $arg != '0000-00-00'){
            $thai_months = [
                1 => 'ม.ค.',
                2 => 'ก.พ.',
                3 => 'มี.ค.',
                4 => 'เม.ย.',
                5 => 'พ.ค.',
                6 => 'มิ.ย.',
                7 => 'ก.ค.',
                8 => 'ส.ค.',
                9 => 'ก.ย.',
                10 => 'ต.ค.',
                11 => 'พ.ย.',
                12 => 'ธ.ค.',
            ];
            $date = Carbon::parse($arg);
            $month = $thai_months[$date->month];
            $year = $date->year + 543;
            return $date->format("j $month $year");
        }
        else{
            return "-";
        }
        //return $date->format("j $month $year H:i:s");
    }

    public static function simpleDateFormat($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        // $strMonthCut = Array("","01","02","03","04","05","06","07","08","09","10","11","12");
        $strMonthThai=$strMonthCut[$strMonth];
  
        // return $strDay." ".$strMonthThai." ".$strYear;
        return $strDay." ".$strMonthThai;
    }

    public static function simpleDateFormatfullmonth($strDate)
    {
 
        $strMonth= date("n",strtotime($strDate));
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
  
        // return $strDay." ".$strMonthThai." ".$strYear;
        return $strMonthThai." ".$strYear;
    }
}