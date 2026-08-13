<?php

declare(strict_types=1);

namespace PicoMapper;

class Collection
{
    /**
     * Returns the first element of collection for which callback returns
     * true.
     *
     * @return mixed
     */
    public static function first(array $collection, callable $callback)
    {
        foreach ($collection as $item) {
            if ($callback($item)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Splits collection into groups indexed by the key returned by
     * callback.
     */
    public static function group(array $collection, callable $callback): array
    {
        $groups = [];

        foreach ($collection as $item) {
            $groups[$callback($item)][] = $item;
        }

        return $groups;
    }

    /**
     * Returns all elements in array a for which no elements in
     * array b exist with the same value for keys.
     *
     * @param string[] $keys
     */
    public static function diffByKeys(array $a, array $b, array $keys): array
    {
        $keys = array_flip($keys);

        return array_udiff($a, $b, fn ($x, $y): int => implode(':', array_intersect_key($x, $keys)) <=> implode(':', array_intersect_key($y, $keys)));
    }

    /**
     * Returns all elements in array a for which an element in array
     * b exists with the same value for keys.
     *
     * @param string[] $keys
     */
    public static function intersectByKeys(array $a, array $b, array $keys): array
    {
        $keys = array_flip($keys);

        return array_uintersect($a, $b, fn ($x, $y): int => implode(':', array_intersect_key($x, $keys)) <=> implode(':', array_intersect_key($y, $keys)));
    }
}
