<?php namespace App\Utility;

class sortUtility {
    public static function BubbleSort($arr) {
        $len = count($arr);

        for($i = $len-1; $i >= 0; $i--) {
            for($j = 1; $j <= $i; $j++) {
                if($arr[$j-1] > $arr[$j]) {
                    $temp = $arr[$j-1];
                    $arr[$j-1] = $arr[$j];
                    $arr[$j] = $temp;
                }
            }
        }

        return $arr;
    }

    public static function QuickSort($arr) {
        if(count($arr) < 2) {
            return $arr;
        }

        $left = $right = array();
        reset($arr);

        $pivot_key = key($arr);
        $pivot = array_shift($arr);

        foreach($arr as $k => $v) {
            if($v < $pivot)
                $left[$k] = $v;
            else
                $right[$k] = $v;
        }

        return array_merge(self::QuickSort($left), array($pivot_key => $pivot), self::QuickSort($right));
    }
}