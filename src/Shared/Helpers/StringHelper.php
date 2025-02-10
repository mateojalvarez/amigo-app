<?php

namespace Src\Shared\Helpers;

class StringHelper
{
    public static function hasNumbers(string $text): bool
    {
        return preg_match('/\d/', $text) === 1;
    }

    public static function hasLowerCase(string $text): bool
    {
        return preg_match('/[a-z]/', $text) === 1;
    }

    public static function hasUpperCase(string $text): bool
    {
        return preg_match('/[A-Z]/', $text) === 1;
    }

    public static function hasSpecialCharacter(string $text): bool
    {
        return preg_match('/\W|_/', $text) === 1;
    }

    public static function hasLength(string $text, int $length): bool
    {
        return strlen($text) == $length;
    }

    public static function getLength(string $string): int
    {
        return strlen($string);
    }

    public static function hasInvalidCharacter(string $string): bool
    {
        return ! preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ0-9'` ]*$/", $string);
    }

    public static function startsWith(string $string, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (str_starts_with($string, $needle)) {
                return true;
            }
        }

        return false;
    }

    public static function getFirstCharacter(string $string): string
    {
        return substr($string, 0, 1);
    }

    public static function obfuscateString(string $string): string
    {
        $length = self::getLength($string);
        $half   = (int) ceil($length / 2);

        $firstHalf = substr($string, 0, $half);

        $secondHalf = str_repeat('*', $length - $half);

        return $firstHalf . $secondHalf;
    }

    public static function capitalizeFirstLetter(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');

        return ucfirst(strtolower($text));
    }
}
