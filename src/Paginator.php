<?php

namespace Innowise\ReqRes;

use ArrayAccess;
use ArrayIterator;
use ArrayObject;
use Countable;
use IteratorAggregate;
use Illuminate\Support\Collection;
use Innowise\ReqRes\DTO\Meta;
use Innowise\ReqRes\DTO\UserDTO;
use Iterator;
use Traversable;

class Paginator extends ArrayObject
{

    public function __construct(
        private Collection $users,
        private Meta $meta
    ) {
    }

    public function hasNextPage(): bool
    {
        return $this->meta->page < $this->meta->totalPages;
    }

    public function getNextPage(): ?int
    {
        if ($this->hasNextPage()) {
            return $this->meta->page + 1;
        }

        return null;
    }

    public function getIterator(): Iterator
    {
        return $this->users->getIterator();
    }

    public function count(): int
    {
        return $this->users->count();
    }

    public function offsetGet($key): UserDTO
    {
        return $this->users->get($key);
    }
    public function offsetExists($key): bool
    {
        return $this->users->offsetExists($key);
    }
}