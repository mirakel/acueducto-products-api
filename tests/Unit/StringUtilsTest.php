<?php

namespace Tests\Unit;

use App\Helpers\StringUtils;
use PHPUnit\Framework\TestCase;

class StringUtilsTest extends TestCase
{
    public function test_returns_true_if_word_is_palindrome(): void
    {
        $word = 'level';
        $this->assertTrue(StringUtils::isPalindrome($word));
    }

    public function test_returns_false_if_word_is_not_palindrome(): void
    {
        $word = 'samsung';
        $this->assertFalse(StringUtils::isPalindrome($word));
    }
}
