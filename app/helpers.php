<?php
if(!function_exists('')) {
    function coin_transform($coin) {
        if($coin >= 1000) {
            $coin = number_format(floor($coin / 1000)) . " K";
            return $coin;
        } else {
            return $coin;
        }
    }
}
