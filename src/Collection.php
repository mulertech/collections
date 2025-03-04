<?php

namespace MulerTech\Collections;

use ArrayAccess;

/**
 * Class Collection
 * @package MulerTech\Collections
 * @author Sébastien Muler
 * @template TKey of array-key
 * @template TValue of mixed
 * @implements ArrayAccess<TKey, TValue>
 */
class Collection implements ArrayAccess
{
    /**
     * @param array<TKey, TValue> $items
     */
    public function __construct(private array $items = [])
    {
    }

    /**
     * @param callable $callback
     * @return bool
     */
    public function all(callable $callback): bool
    {
        return array_all($this->items, $callback);
    }

    /**
     * @param callable $callback
     * @return bool
     */
    public function any(callable $callback): bool
    {
        return array_any($this->items, $callback);
    }

    /**
     * @param int $sortFlags
     * @return void
     */
    public function arsort(int $sortFlags = SORT_REGULAR): void
    {
        arsort($this->items, $sortFlags);
    }

    /**
     * @param int $sortFlags
     * @return void
     */
    public function asort(int $sortFlags = SORT_REGULAR): void
    {
        asort($this->items, $sortFlags);
    }

    /**
     * @param int $case
     * @return void
     */
    public function changeKeyCase(int $case = CASE_LOWER): void
    {
        $this->items = array_change_key_case($this->items, $case);
    }

    /**
     * @param int $length
     * @param bool $preserveKeys
     * @return self<int, self<int, TValue>>
     */
    public function chunk(int $length, bool $preserveKeys = false): self
    {
        if ($length <= 0) {
            return new self();
        }

        $chunks = array_chunk($this->items, $length, $preserveKeys);

        return new self(
            array_map(
                fn ($chunk) => new self($chunk),
                $chunks
            )
        );
    }

    /**
     * @param int|string|null $columnKey
     * @param int|string|null $indexKey
     * @return $this
     */
    public function column(int|string|null $columnKey, int|string|null $indexKey = null): self
    {
        $this->items = array_column($this->items, $columnKey, $indexKey);

        return $this;
    }

    /**
     * @param self<int, TValue> $values
     * @return self<int|string, TValue>
     */
    public function combine(self $values): self
    {
        $combined = array_combine($this->items, $values->items());
        return new self($combined);
    }

    /**
     * @param 0|1 $mode
     * @return int
     */
    public function count($mode = COUNT_NORMAL): int
    {
        return count($this->items, $mode);
    }

    /**
     * @return self<int|string, int<1, max>>
     */
    public function countValues(): self
    {
        return new self(array_count_values($this->items));
    }

    /**
     * @return mixed
     */
    public function current(): mixed
    {
        return current($this->items);
    }

    /**
     * @param self<TKey, TValue> ...$collections
     * @return self<TKey, TValue>
     */
    public function diff(self ...$collections): self
    {
        return new self(array_diff($this->items, ...array_map(fn ($collection) => $collection->items, $collections)));
    }

    /**
     * @param self<TKey, TValue> ...$collections
     * @return self<TKey, TValue>
     */
    public function diffAssoc(self ...$collections): self
    {
        return new self(
            array_diff_assoc(
                $this->items,
                ...array_map(fn ($collection) => $collection->items, $collections)
            )
        );
    }

    /**
     * @param self<TKey, TValue> ...$collections
     * @return self<TKey, TValue>
     */
    public function diffKey(self ...$collections): self
    {
        return new self(
            array_diff_key(
                $this->items,
                ...array_map(fn ($collection) => $collection->items, $collections)
            )
        );
    }

    /**
     * @param callable $callback
     * @param self<TKey, TValue> $collection
     * @return self<int|string, TValue>
     */
    public function diffUassoc(callable $callback, self $collection): self
    {
        return new self(array_diff_uassoc($this->items, $collection->items(), $callback));
    }

    /**
     * @param callable $callback
     * @param self<TKey, TValue> $collection
     * @return self<TKey, TValue>
     */
    public function diffUkey(callable $callback, self $collection): self
    {
        return new self(array_diff_ukey($this->items, $collection->items(), $callback));
    }

    /**
     * @return mixed
     */
    public function end(): mixed
    {
        return end($this->items);
    }

    /**
     * @param 0|1|2|3|4|5|6|256 $flags
     * @param string $prefix
     * @return int
     */
    public function extract($flags = EXTR_OVERWRITE, string $prefix = ''): int
    {
        return extract($this->items, $flags, $prefix);
    }

    /**
     * @param int $startIndex
     * @param int $count
     * @param mixed $value
     * @return self<int, TValue>
     */
    public function fill(int $startIndex, int $count, mixed $value): self
    {
        return new self(array_fill($startIndex, $count, $value));
    }

    /**
     * @param array<int, int|string> $keys
     * @param mixed $value
     * @return self<int|string, TValue>
     */
    public function fillKeys(array $keys, mixed $value): self
    {
        return new self(array_fill_keys($keys, $value));
    }

    /**
     * @param callable|null $callback
     * @param int $mode
     * @return void
     */
    public function filter(?callable $callback = null, int $mode = 0): void
    {
        $this->items = array_filter($this->items, $callback, $mode);
    }

    /**
     * @param callable $callback
     * @return mixed
     */
    public function find(callable $callback): mixed
    {
        return array_find($this->items, $callback);
    }

    /**
     * @param callable $callback
     * @return mixed
     */
    public function findKey(callable $callback): mixed
    {
        return array_find_key($this->items, $callback);
    }

    /**
     * @return self<int|string, TValue>
     */
    public function flip(): self
    {
        return new self(array_flip($this->items));
    }

    /**
     * @param mixed $needle
     * @param bool $strict
     * @return bool
     */
    public function inArray(mixed $needle, bool $strict = false): bool
    {
        return in_array($needle, $this->items, $strict);
    }

    /**
     * @param self<TKey, TValue> ...$collections
     * @return self<TKey, TValue>
     */
    public function intersect(self ...$collections): self
    {
        return new self(
            array_intersect(
                $this->items,
                ...array_map(fn ($collection) => $collection->items(), $collections)
            )
        );
    }

    /**
     * @param self<TKey, TValue> ...$collections
     * @return self<TKey, TValue>
     */
    public function intersectAssoc(self ...$collections): self
    {
        return new self(
            array_intersect_assoc(
                $this->items,
                ...array_map(fn ($collection) => $collection->items(), $collections)
            )
        );
    }

    /**
     * @param self<TKey, TValue> ...$collections
     * @return self<TKey, TValue>
     */
    public function intersectKey(self ...$collections): self
    {
        return new self(
            array_intersect_key(
                $this->items,
                ...array_map(fn ($collection) => $collection->items(), $collections)
            )
        );
    }

    /**
     * @param callable $callback
     * @param self<TKey, TValue> $collection
     * @return self<TKey, TValue>
     */
    public function intersectUassoc(callable $callback, self $collection): self
    {
        return new self(array_intersect_uassoc($this->items, $collection->items(), $callback));
    }

    /**
     * @param callable $callback
     * @param self<TKey, TValue> $collection
     * @return self<TKey, TValue>
     */
    public function intersectUkey(callable $callback, self $collection): self
    {
        return new self(array_intersect_ukey($this->items, $collection->items(), $callback));
    }

    /**
     * @return bool
     */
    public function isList(): bool
    {
        return array_is_list($this->items);
    }

    /**
     * @return array<TKey, TValue>
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * @return int|string|null
     */
    public function key(): int|string|null
    {
        return key($this->items);
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function keyExists(mixed $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @return int|string|null
     */
    public function keyFirst(): int|string|null
    {
        return array_key_first($this->items);
    }

    /**
     * @return int|string|null
     */
    public function keyLast(): int|string|null
    {
        return array_key_last($this->items);
    }

    /**
     * @param mixed|null $filterValue
     * @param bool $strict
     * @return self<TKey, TValue>
     */
    public function keys(mixed $filterValue = null, bool $strict = false): self
    {
        if ($filterValue === null) {
            return new self(array_keys($this->items));
        }

        return new self(array_keys($this->items, $filterValue, $strict));
    }

    /**
     * @param int $sortFlags
     * @return void
     */
    public function krsort(int $sortFlags = SORT_REGULAR): void
    {
        krsort($this->items, $sortFlags);
    }

    /**
     * @param int $sortFlags
     * @return void
     */
    public function ksort(int $sortFlags = SORT_REGULAR): void
    {
        ksort($this->items, $sortFlags);
    }

    /**
     * @param callable $callback
     * @param self<TKey, TValue> ...$collections
     * @return void
     */
    public function map(callable $callback, self ...$collections): void
    {
        $this->items = array_map(
            $callback,
            $this->items,
            ...array_map(fn ($collection) => $collection->items(), $collections)
        );
    }

    /**
     * @param self<TKey, TValue> ...$collections
     * @return void
     */
    public function merge(self ...$collections): void
    {
        $this->items = array_merge($this->items, ...array_map(fn ($collection) => $collection->items(), $collections));
    }

    /**
     * @param self<TKey, TValue> ...$collections
     * @return void
     */
    public function mergeRecursive(self ...$collections): void
    {
        $this->items = array_merge_recursive(
            $this->items,
            ...array_map(fn ($collection) => $collection->items(), $collections)
        );
    }

    /**
     * @param mixed $sortOrder
     * @param mixed $sortFlags
     * @param mixed ...$rest
     * @return void
     */
    public function multisort(mixed $sortOrder = SORT_ASC, mixed $sortFlags = SORT_REGULAR, mixed ...$rest): void
    {
        array_multisort($this->items, $sortOrder, $sortFlags, ...$rest);
    }

    /**
     * @return void
     */
    public function natcasesort(): void
    {
        natcasesort($this->items);
    }

    /**
     * @return void
     */
    public function natsort(): void
    {
        natsort($this->items);
    }

    /**
     * @return mixed
     */
    public function next(): mixed
    {
        return next($this->items);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    /**
     * @param int $length
     * @param mixed $value
     * @return void
     */
    public function pad(int $length, mixed $value): void
    {
        $this->items = array_pad($this->items, $length, $value);
    }

    /**
     * @return mixed
     */
    public function pop(): mixed
    {
        return array_pop($this->items);
    }

    /**
     * @return mixed
     */
    public function prev(): mixed
    {
        return prev($this->items);
    }

    /**
     * @return int|float
     */
    public function product(): int|float
    {
        return array_product($this->items);
    }

    /**
     * @param mixed ...$values
     * @return void
     */
    public function push(mixed ...$values): void
    {
        array_push($this->items, ...$values);
    }

    /**
     * @param int $num
     * @return int|string|array<int, int|string>
     */
    public function rand(int $num = 1): int|string|array
    {
        return array_rand($this->items, $num);
    }

    /**
     * @param string|int|float $start
     * @param string|int|float $end
     * @param int|float $step
     * @return self<int, string|int|float>
     */
    public function range(string|int|float $start, string|int|float $end, int|float $step = 1): self
    {
        return new self(range($start, $end, $step));
    }

    /**
     * @param callable $callback
     * @param mixed|null $initial
     * @return mixed
     */
    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        return array_reduce($this->items, $callback, $initial);
    }

    /**
     * @param self<TKey, TValue> ...$collections
     * @return void
     */
    public function replace(self ...$collections): void
    {
        $this->items = array_replace(
            $this->items,
            ...array_map(fn ($collection) => $collection->items(), $collections)
        );
    }

    /**
     * @param self<TKey, TValue> ...$collections
     * @return void
     */
    public function replaceRecursive(self ...$collections): void
    {
        $this->items = array_replace_recursive(
            $this->items,
            ...array_map(fn ($collection) => $collection->items(), $collections)
        );
    }

    /**
     * @return mixed
     */
    public function reset(): mixed
    {
        return reset($this->items);
    }

    /**
     * @param bool $preserveKeys
     * @return void
     */
    public function reverse(bool $preserveKeys = false): void
    {
        $this->items = array_reverse($this->items, $preserveKeys);
    }

    /**
     * @param int $sortFlags
     * @return void
     */
    public function rsort(int $sortFlags = SORT_REGULAR): void
    {
        rsort($this->items, $sortFlags);
    }

    /**
     * @param mixed $needle
     * @param bool $strict
     * @return int|string|false
     */
    public function search(mixed $needle, bool $strict = false): int|string|false
    {
        return array_search($needle, $this->items, $strict);
    }

    /**
     * @return mixed
     */
    public function shift(): mixed
    {
        return array_shift($this->items);
    }

    /**
     * @return void
     */
    public function shuffle(): void
    {
        shuffle($this->items);
    }

    /**
     * @param int $offset
     * @param int|null $length
     * @param bool $preserveKeys
     * @return self<TKey, TValue>
     */
    public function slice(int $offset, ?int $length = null, bool $preserveKeys = false): self
    {
        return new self(array_slice($this->items, $offset, $length, $preserveKeys));
    }

    /**
     * @param int $sortFlags
     * @return void
     */
    public function sort(int $sortFlags = SORT_REGULAR): void
    {
        sort($this->items, $sortFlags);
    }

    /**
     * @param int $offset
     * @param int|null $length
     * @param mixed $replacement
     * @return void
     */
    public function splice(int $offset, ?int $length = null, mixed $replacement = []): void
    {
        array_splice($this->items, $offset, $length, $replacement);
    }

    /**
     * @return int|float
     */
    public function sum(): int|float
    {
        return array_sum($this->items);
    }

    /**
     * @param callable $callback
     * @return void
     */
    public function uasort(callable $callback): void
    {
        uasort($this->items, $callback);
    }

    /**
     * @param callable $callback
     * @param self<TKey, TValue> $collection
     * @return self<TKey, TValue>
     */
    public function udiff(callable $callback, self $collection): self
    {
        return new self(array_udiff($this->items, $collection->items(), $callback));
    }

    /**
     * @param callable $callback
     * @param self<TKey, TValue> $collection
     * @return self<TKey, TValue>
     */
    public function udiffAssoc(callable $callback, self $collection): self
    {
        return new self(array_udiff_assoc($this->items, $collection->items(), $callback));
    }

    /**
     * @param callable $valueCallback
     * @param callable $keyCallback
     * @param self<TKey, TValue> $collection
     * @return self<TKey, TValue>
     */
    public function udiffUassoc(callable $valueCallback, callable $keyCallback, self $collection): self
    {
        return new self(array_udiff_uassoc($this->items, $collection->items(), $valueCallback, $keyCallback));
    }

    /**
     * @param callable $callback
     * @param self<TKey, TValue> $collection
     * @return self<TKey, TValue>
     */
    public function uintersect(callable $callback, self $collection): self
    {
        return new self(array_uintersect($this->items, $collection->items(), $callback));
    }

    /**
     * @param callable $callback
     * @param self<TKey, TValue> $collection
     * @return self<TKey, TValue>
     */
    public function uintersectAssoc(callable $callback, self $collection): self
    {
        return new self(array_uintersect_assoc($this->items, $collection->items(), $callback));
    }

    /**
     * @param callable $valueCallback
     * @param callable $keyCallback
     * @param self<TKey, TValue> $collection
     * @return self<TKey, TValue>
     */
    public function uintersectUassoc(callable $valueCallback, callable $keyCallback, self $collection): self
    {
        return new self(array_uintersect_uassoc($this->items, $collection->items(), $valueCallback, $keyCallback));
    }

    /**
     * @param callable $callback
     * @return void
     */
    public function uksort(callable $callback): void
    {
        uksort($this->items, $callback);
    }

    /**
     * @param int $sortFlags
     * @return void
     */
    public function unique(int $sortFlags = SORT_STRING): void
    {
        $this->items = array_unique($this->items, $sortFlags);
    }

    /**
     * @param mixed ...$values
     * @return int
     */
    public function unshift(mixed ...$values): int
    {
        return array_unshift($this->items, ...$values);
    }

    /**
     * @param callable $callback
     * @return void
     */
    public function usort(callable $callback): void
    {
        usort($this->items, $callback);
    }

    /**
     * @return self<int, TValue>
     */
    public function values(): self
    {
        return new self(array_values($this->items));
    }

    /**
     * @param callable $callback
     * @param mixed|null $arg
     * @return void
     */
    public function walk(callable $callback, mixed $arg = null): void
    {
        array_walk($this->items, $callback, $arg);
    }

    /**
     * @param callable $callback
     * @param mixed|null $arg
     * @return void
     */
    public function walkRecursive(callable $callback, mixed $arg = null): void
    {
        array_walk_recursive($this->items, $callback, $arg);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function contains(mixed $value): bool
    {
        foreach ($this->items as $item) {
            if (is_object($item) && is_object($value)) {
                if ($item == $value) {
                    return true;
                }
            } elseif ($item === $value) {
                return true;
            }
        }
        return false;
    }
}
