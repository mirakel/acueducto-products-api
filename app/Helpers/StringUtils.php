<?php

namespace App\Helpers;

class StringUtils
{
    /**
     * @param string $word
     *
     * @return bool
     */
    public static function isPalindrome(string $word): bool {
        $word = str_replace(' ', '', strtolower($word));
        $reverse_word = strrev($word);
        return $word == $reverse_word;
    }
}
