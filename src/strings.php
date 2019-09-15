<?php

declare(strict_types=1);

namespace php\strings;

function compare(string $a, string $b) : int
{
    return $a <=> $b;
}

function contains(string $string, string $substring) : bool
{
    if ($substring === '') {
        return true;
    }

    return index($string, $substring) >= 0;
}

function has_prefix(string $string, string $prefix) : bool
{
    if ($prefix === '') {
        return true;
    }

    return index($string, $prefix) === 0;
}

function has_suffix(string $string, string $suffix) : bool
{
    if ($suffix === '') {
        return true;
    }

    return substr($string, -1 * strlen($suffix)) === $suffix;
}

function index(string $string, string $substring) : int
{
    $pos = strpos($string, $substring);

    if ($pos === false) {
        return -1;
    }

    return $pos;
}

function join(array $strings, string $separator) : string
{
    return implode($separator, $strings);
}

function last_index(string $string, string $substring) : int
{
    $pos = mb_strrpos($string, $substring);

    if ($pos === false) {
        return -1;
    }

    return $pos;
}

function str_split(string $string, int $length = 1): array
{
    if ($length <= 0) {
        return [];
    }

    $i_max = mb_strlen($string);
    if ($i_max <= 127) {
        $ret = [];
        for ($i = 0; $i < $i_max; ++$i) {
            $ret[] = mb_substr($string, $i, 1);
        }
    } else {
        $return_array = [];
        preg_match_all('/./us', $string, $return_array);
        $ret = $return_array[0] ?? [];
    }

    if ($length > 1) {
        $ret = array_chunk($ret, $length);

        return array_map(
            static function (array &$item): string {
                return implode('', $item);
            },
            $ret
        );
    }

    return $ret;
}

function map(callable $fn, string $string) : string
{
    return implode(
        array_map(
            $fn,
            str_split($string)
        )
    );
}

function repeat(string $string, int $count) : string
{
    if ($count < 0) {
        throw new \UnexpectedValueException("Count is required to be >= 0.");
    }

    return str_repeat($string, $count);
}

function replace(string $string, string $old, string $new, int $n = -1)
{
    if ($n < 0) {
        return str_replace($old, $new, $string);
    }

    /** @noinspection PregQuoteUsageInspection */
    return preg_replace('(' . preg_quote($old) . ')u', $new, $string, $n);
}

function split(string $string, string $separator, int $limit = PHP_INT_MAX) : array
{
    if ($separator === '') {
        $chars = str_split($string);

        if ($limit > count($chars)) {
            return $chars;
        }

        return array_merge(
            array_slice($chars, 0, $limit - 1),
            [implode($separator, array_slice($chars, $limit - 1))]
        );
    }

    return explode($separator, $string, $limit);
}

function to_lower(string $string) : string
{
    return strtolower($string);
}

function to_upper(string $string) : string
{
    return strtoupper($string);
}

function trim(string $string, string $mask = null)
{
    if ($mask) {
        /** @noinspection PregQuoteUsageInspection */
        $mask = preg_quote($mask);
        $pattern = "^[" . $mask . "]+|[" . $mask . "]+\$";
    } else {
        $pattern = '^[\\s]+|[\\s]+$';
    }

    return (string) mb_ereg_replace($pattern, '', $string);
}

function trim_left(string $string, string $mask = " \t\n\r\0\x0B")
{
    return \ltrim($string, $mask);
}

function trim_right(string $string, string $mask = " \t\n\r\0\x0B")
{
    return \rtrim($string, $mask);
}
