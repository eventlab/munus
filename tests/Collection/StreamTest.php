<?php

declare(strict_types=1);

namespace Munus\Tests\Collection;

use Munus\Collection\Stream;
use PHPUnit\Framework\TestCase;

final class StreamTest extends TestCase
{
    public function testStreamIterator(): void
    {
        $iterator = Stream::ofAll([1, 2, 3])->iterator();

        self::assertTrue($iterator->hasNext());
        self::assertEquals(1, $iterator->next());
        self::assertEquals(2, $iterator->next());
        self::assertEquals(3, $iterator->next());
        self::assertFalse($iterator->hasNext());
    }

    public function testStreamMap(): void
    {
        self::assertTrue(
            Stream::ofAll([1, 2, 3])->map(function (int $int): int {
                return $int * 2;
            })->equals(Stream::ofAll([2, 4, 6]))
        );
    }

    public function testStreamMapSingle(): void
    {
        self::assertTrue(
            Stream::of(6)->map(function (int $int): int {
                return $int * 6;
            })->equals(Stream::ofAll([36]))
        );
    }

    public function testStreamRange(): void
    {
        self::assertTrue(
            Stream::range(1, 5)->equals(Stream::ofAll([1, 2, 3, 4, 5]))
        );
    }
}
