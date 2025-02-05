<?php

declare(strict_types=1);

namespace Munus\Collection\Iterator;

use Munus\Collection\Iterator;
use Munus\Collection\Stream;
use Munus\Collection\Stream\Cons;
use Munus\Functiοn\Supplier;
use Munus\Lazy;

/**
 * @template T
 * @template-extends Iterator<T>
 */
final class StreamIterator extends Iterator
{
    /**
     * @var Supplier<Stream<T>>
     */
    private $current;

    /**
     * @param Cons<T> $current
     */
    public function __construct(Cons $current)
    {
        $this->current = Lazy::ofValue($current);
    }

    public function hasNext(): bool
    {
        return !$this->current->get()->isEmpty();
    }

    /**
     * @return T
     */
    public function next()
    {
        if (!$this->hasNext()) {
            throw new \LogicException('next() on empty iterator');
        }
        /** @var Stream<T> $stream */
        $stream = $this->current->get();
        $this->current = Lazy::of(function () use ($stream) {
            return $stream->tail();
        });

        return $stream->head();
    }
}
