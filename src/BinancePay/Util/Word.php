<?php

namespace BinancePay\Util;

final class Word
{

    public static function getRandomWord(int $length = 32)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 1; $i <= $length; $i++) {
            $pos = mt_rand(0, strlen($chars) - 1);
            $char = $chars[$pos];
            $str .= $char;
        }
        return $str;
    }
}
