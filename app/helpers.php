<?php
if(!function_exists('')) {
    function coin_transform() {
        $totalCoin = auth()->user()->hasCoins->sum('coin');

        if($totalCoin >= 1000) {
            $coin = number_format(floor($totalCoin / 1000)) . " k";
            return $totalCoin;
        } else {
            return $totalCoin;
        }
    }

    function number_transform($number) {
        if($number >= 1000) {
            $displayNumber = number_format(floor($number / 1000)) . " k";
            return $displayNumber;
        } else {
            return $number;
        }
    }
}
