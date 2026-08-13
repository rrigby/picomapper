<?php

declare(strict_types=1);

namespace PicoMapper;

use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testFirstReturnsMatch(): void
    {
        $result = Collection::first(
            [['a' => 1], ['a' => 2], ['a' => 3]],
            fn ($x): bool => $x['a'] === 2
        );

        $this->assertEquals(['a' => 2], $result);
    }

    public function testFirstReturnsNullWhenNoMatch(): void
    {
        $result = Collection::first([['a' => 1]], fn ($x): bool => $x['a'] === 99);

        $this->assertNull($result);
    }

    public function testGroupBucketsByKey(): void
    {
        $result = Collection::group(
            [['type' => 'a', 'v' => 1], ['type' => 'b', 'v' => 2], ['type' => 'a', 'v' => 3]],
            fn ($x) => $x['type']
        );

        $this->assertCount(2, $result['a']);
        $this->assertCount(1, $result['b']);
    }

    public function testDiffByKeysReturnsNonMatching(): void
    {
        $a = [['id' => 1], ['id' => 2], ['id' => 3]];
        $b = [['id' => 2]];

        $result = Collection::diffByKeys($a, $b, ['id']);

        $this->assertCount(2, $result);
    }

    public function testIntersectByKeysReturnsMatching(): void
    {
        $a = [['id' => 1, 'label' => 'A'], ['id' => 2, 'label' => 'B']];
        $b = [['id' => 2]];

        $result = Collection::intersectByKeys($a, $b, ['id']);

        $this->assertCount(1, $result);
        $this->assertEquals('B', array_values($result)[0]['label']);
    }
}
