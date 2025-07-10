<?php

namespace Tangibledesign\Framework\Core;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;

class Collection implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{
    protected array $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function make(array $items = []): Collection
    {
        return new static($items);
    }

    public function each(callable $callback): Collection
    {
        foreach ($this->items as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }

        return $this;
    }

    public function filter(callable $callback = null): Collection
    {
        if ($callback) {
            return new static(array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH));
        }

        return new static(array_filter($this->items));
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function jsonSerialize(): array
    {
        return array_map(static function ($value) {
            if ($value instanceof JsonSerializable) {
                return $value->jsonSerialize();
            }

            return $value;
        }, $this->items);
    }

    public function values(): array
    {
        return array_values($this->items);
    }

    public function toValues(): Collection
    {
        return new static(array_values($this->items));
    }

    public function first($default = null)
    {
        /** @noinspection LoopWhichDoesNotLoopInspection */
        foreach ($this->items as $item) {
            return $item;
        }

        return $default;
    }

    public function last(callable $callback = null, $default = null)
    {
        if ($callback === null) {
            return empty($this->items) ? $default : end($this->items);
        }

        $items = array_reverse($this->items);
        /** @noinspection PhpConditionAlreadyCheckedInspection */
        if ($callback === null) {
            if (empty($items)) {
                return $default;
            }

            foreach ($items as $item) {
                return $item;
            }
        }

        foreach ($items as $key => $item) {
            return $callback($item, $key);
        }

        return $default;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    public function map(callable $callback): Collection
    {
        $keys = array_keys($this->items);
        $items = array_map($callback, $this->items, $keys);

        return new static(array_combine($keys, $items));
    }

    public function merge($items): Collection
    {
        if ($items instanceof self) {
            $items = $items->values();
        }

        return self::make(array_merge($this->items, $items));
    }

    public function find(callable $callback)
    {
        foreach ($this->items as $key => $item) {
            if ($callback($item, $key)) {
                return $item;
            }
        }

        return false;
    }

    public function reverse(): Collection
    {
        $this->items = array_reverse($this->items);

        return $this;
    }

    public function implode(string $separator = ', '): string
    {
        return implode($separator, $this->items);
    }

    public function slice(int $offset = 0, $length = null): Collection
    {
        return self::make(array_slice($this->items, $offset, $length));
    }

    public function unique(): Collection
    {
        $this->items = array_unique($this->items);

        return $this;
    }

    public function take(int $number, int $offset = 0): Collection
    {
        return self::make(array_slice($this->items, $offset, $number));
    }

    public function add($item): void
    {
        $this->items[] = $item;
    }

    public function sortBy(string $key, int $sortFlags = SORT_REGULAR): Collection
    {
        $items = $this->items;
        usort($items, static function ($a, $b) use ($key, $sortFlags) {
            return $sortFlags === SORT_REGULAR ? $a[$key] <=> $b[$key] : strnatcmp($a[$key], $b[$key]);
        });

        return self::make($items);
    }

    public function average(callable $callback): float
    {
        if ($this->isEmpty()) {
            return 0.0;
        }

        $sum = array_reduce($this->items, static function ($carry, $item) use ($callback) {
            return $carry + $callback($item);
        }, 0.0);

        return $sum / count($this->items);
    }
}