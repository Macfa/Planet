<?php
if(!function_exists('')) {
    function coin_transform() {
        $totalCoin = auth()->user()->hasCoins->sum('coin');

        if($totalCoin >= 1000) {
            $coin = number_format(floor($totalCoin / 1000)) . " K";
            return $totalCoin;
        } else {
            return $totalCoin;
        }
    }
}
