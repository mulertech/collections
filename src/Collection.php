<?php

namespace MulerTech\Collections;

/**
 * Class Collection.
 *
 * @author Sébastien Muler
 *
 * @template TKey of array-key
 * @template TValue of mixed
 *
 * @implements \ArrayAccess<TKey, TValue>
 * @implements \IteratorAggregate<TKey, TValue>
 */
class Collection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * @param array<TKey, TValue> $items
     */
    public function __construct(private array $items = [])
    {
    }

    public function all(callable $callback): bool
    {
        return array_all($this->items, $callback);
    }

    public function any(callable $callback): bool
    {
        return array_any($this->items, $callback);
    }

    public function arsort(int $sortFlags = SORT_REGULAR): void
    {
        arsort($this->items, $sortFlags);
    }

    public function asort(int $sortFlags = SORT_REGULAR): void
    {
        asort($this->items, $sortFlags);
    }

    public function changeKeyCase(int $case = CASE_LOWER): void
    {
        $this->items = array_change_key_case($this->items, $case);
    }

    /**
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
                static fn ($chunk) => new self($chunk),
                $chunks
            )
        );
    }

    /**
     * @return $this
     */
    public function column(int|string|null $columnKey, int|string|null $indexKey = null): self
    {
        $this->items = array_column($this->items, $columnKey, $indexKey);

        return $this;
    }

    /**
     * @param self<int, TValue> $values
     *
     * @return self<int|string, TValue>
     */
    public function combine(self $values): self
    {
        $combined = array_combine($this->items, $values->items());

        return new self($combined);
    }

    public function contains(mixed $value): bool
    {
        return in_array($value, $this->items, true);
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return self<int|string, int<1, max>>
     */
    public function countValues(): self
    {
        /** @var array<int|string, int<1, max>> $counted */
        $counted = array_count_values($this->items);

        return new self($counted);
    }

    public function current(): mixed
    {
        return current($this->items);
    }

    /**
     * @param self<TKey, TValue> ...$collections
     *
     * @return self<TKey, TValue>
     */
    public function diff(self ...$collections): self
    {
        return new self(
            array_diff($this->items, ...array_map(static fn ($collection) => $collection->items, $collections))
        );
    }

    /**
     * @param self<TKey, TValue> ...$collections
     *
     * @return self<TKey, TValue>
     */
    public function diffAssoc(self ...$collections): self
    {
        return new self(
            array_diff_assoc(
                $this->items,
                ...array_map(static fn ($collection) => $collection->items, $collections)
            )
        );
    }

    /**
     * @param self<TKey, TValue> ...$collections
     *
     * @return self<TKey, TValue>
     */
    public function diffKey(self ...$collections): self
    {
        return new self(
            array_diff_key(
                $this->items,
                ...array_map(static fn ($collection) => $collection->items, $collections)
            )
        );
    }

    /**
     * @param self<TKey, TValue> $collection
     *
     * @return self<int|string, TValue>
     */
    public function diffUassoc(callable $callback, self $collection): self
    {
        return new self(array_diff_uassoc($this->items, $collection->items(), $callback));
    }

    /**
     * @param self<TKey, TValue> $collection
     *
     * @return self<TKey, TValue>
     */
    public function diffUkey(callable $callback, self $collection): self
    {
        return new self(array_diff_ukey($this->items, $collection->items(), $callback));
    }

    public function end(): mixed
    {
        return end($this->items);
    }

    /**
     * @param 0|1|2|3|4|5|6|256 $flags
     */
    public function extract($flags = EXTR_OVERWRITE, string $prefix = ''): int
    {
        return extract($this->items, $flags, $prefix);
    }

    /**
     * @return self<int, TValue>
     */
    public function fill(int $startIndex, int $count, mixed $value): self
    {
        return new self(array_fill($startIndex, $count, $value));
    }

    /**
     * @param array<int, int|string> $keys
     *
     * @return self<int|string, TValue>
     */
    public function fillKeys(array $keys, mixed $value): self
    {
        return new self(array_fill_keys($keys, $value));
    }

    public function filter(?callable $callback = null, int $mode = 0): void
    {
        $this->items = array_filter($this->items, $callback, $mode);
    }

    public function find(callable $callback): mixed
    {
        return array_find($this->items, $callback);
    }

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

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function inArray(mixed $needle, bool $strict = false): bool
    {
        return in_array($needle, $this->items, $strict);
    }

    /**
     * @param self<TKey, TValue> ...$collections
     *
     * @return self<TKey, TValue>
     */
    public function intersect(self ...$collections): self
    {
        return new self(
            array_intersect(
                $this->items,
                ...array_map(static fn ($collection) => $collection->items(), $collections)
            )
        );
    }

    /**
     * @param self<TKey, TValue> ...$collections
     *
     * @return self<TKey, TValue>
     */
    public function intersectAssoc(self ...$collections): self
    {
        return new self(
            array_intersect_assoc(
                $this->items,
                ...array_map(static fn ($collection) => $collection->items(), $collections)
            )
        );
    }

    /**
     * @param self<TKey, TValue> ...$collections
     *
     * @return self<TKey, TValue>
     */
    public function intersectKey(self ...$collections): self
    {
        return new self(
            array_intersect_key(
                $this->items,
                ...array_map(static fn ($collection) => $collection->items(), $collections)
            )
        );
    }

    /**
     * @param self<TKey, TValue> $collection
     *
     * @return self<TKey, TValue>
     */
    public function intersectUassoc(callable $callback, self $collection): self
    {
        return new self(array_intersect_uassoc($this->items, $collection->items(), $callback));
    }

    /**
     * @param self<TKey, TValue> $collection
     *
     * @return self<TKey, TValue>
     */
    public function intersectUkey(callable $callback, self $collection): self
    {
        return new self(array_intersect_ukey($this->items, $collection->items(), $callback));
    }

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

    public function key(): int|string|null
    {
        return key($this->items);
    }

    public function keyExists(mixed $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    public function keyFirst(): int|string|null
    {
        return array_key_first($this->items);
    }

    public function keyLast(): int|string|null
    {
        return array_key_last($this->items);
    }

    /**
     * @return self<TKey, TValue>
     */
    public function keys(mixed $filterValue = null, bool $strict = false): self
    {
        if (null === $filterValue) {
            return new self(array_keys($this->items));
        }

        return new self(array_keys($this->items, $filterValue, $strict));
    }

    public function krsort(int $sortFlags = SORT_REGULAR): void
    {
        krsort($this->items, $sortFlags);
    }

    public function ksort(int $sortFlags = SORT_REGULAR): void
    {
        ksort($this->items, $sortFlags);
    }

    /**
     * @param self<TKey, TValue> ...$collections
     */
    public function map(callable $callback, self ...$collections): void
    {
        $this->items = array_map(
            $callback,
            $this->items,
            ...array_map(static fn ($collection) => $collection->items(), $collections)
        );
    }

    /**
     * @param self<TKey, TValue> ...$collections
     */
    public function merge(self ...$collections): void
    {
        $this->items = array_merge(
            $this->items,
            ...array_map(static fn ($collection) => $collection->items(), $collections)
        );
    }

    /**
     * @param self<TKey, TValue> ...$collections
     */
    public function mergeRecursive(self ...$collections): void
    {
        $this->items = array_merge_recursive(
            $this->items,
            ...array_map(static fn ($collection) => $collection->items(), $collections)
        );
    }

    public function multisort(mixed $sortOrder = SORT_ASC, mixed $sortFlags = SORT_REGULAR, mixed ...$rest): void
    {
        array_multisort($this->items, $sortOrder, $sortFlags, ...$rest);
    }

    public function natcasesort(): void
    {
        natcasesort($this->items);
    }

    public function natsort(): void
    {
        natsort($this->items);
    }

    public function next(): mixed
    {
        return next($this->items);
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (null === $offset) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    public function pad(int $length, mixed $value): void
    {
        $this->items = array_pad($this->items, $length, $value);
    }

    public function pop(): mixed
    {
        return array_pop($this->items);
    }

    public function prev(): mixed
    {
        return prev($this->items);
    }

    public function product(): int|float
    {
        return array_product($this->items);
    }

    public function push(mixed ...$values): void
    {
        array_push($this->items, ...$values);
    }

    /**
     * @return int|string|array<int, int|string>
     */
    public function rand(int $num = 1): int|string|array
    {
        return array_rand($this->items, $num);
    }

    /**
     * @return self<int, string|int|float>
     */
    public function range(string|int|float $start, string|int|float $end, int|float $step = 1): self
    {
        return new self(range($start, $end, $step));
    }

    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        return array_reduce($this->items, $callback, $initial);
    }

    public function remove(int|string $key): void
    {
        if (!array_key_exists($key, $this->items)) {
            return;
        }

        unset($this->items[$key]);
    }

    public function removeItem(mixed $item, bool $strict = true): bool
    {
        $key = array_search($item, $this->items, $strict);

        if (false === $key) {
            return false;
        }

        unset($this->items[$key]);

        return true;
    }

    /**
     * @param self<TKey, TValue> ...$collections
     */
    public function replace(self ...$collections): void
    {
        $this->items = array_replace(
            $this->items,
            ...array_map(static fn ($collection) => $collection->items(), $collections)
        );
    }

    /**
     * @param self<TKey, TValue> ...$collections
     */
    public function replaceRecursive(self ...$collections): void
    {
        $this->items = array_replace_recursive(
            $this->items,
            ...array_map(static fn ($collection) => $collection->items(), $collections)
        );
    }

    public function reset(): mixed
    {
        return reset($this->items);
    }

    public function reverse(bool $preserveKeys = false): void
    {
        $this->items = array_reverse($this->items, $preserveKeys);
    }

    public function rsort(int $sortFlags = SORT_REGULAR): void
    {
        rsort($this->items, $sortFlags);
    }

    public function search(mixed $needle, bool $strict = false): int|string|false
    {
        return array_search($needle, $this->items, $strict);
    }

    public function shift(): mixed
    {
        return array_shift($this->items);
    }

    public function shuffle(): void
    {
        shuffle($this->items);
    }

    /**
     * @return self<TKey, TValue>
     */
    public function slice(int $offset, ?int $length = null, bool $preserveKeys = false): self
    {
        return new self(array_slice($this->items, $offset, $length, $preserveKeys));
    }

    public function sort(int $sortFlags = SORT_REGULAR): void
    {
        sort($this->items, $sortFlags);
    }

    public function splice(int $offset, ?int $length = null, mixed $replacement = []): void
    {
        array_splice($this->items, $offset, $length, $replacement);
    }

    public function sum(): int|float
    {
        return array_sum($this->items);
    }

    public function uasort(callable $callback): void
    {
        uasort($this->items, $callback);
    }

    /**
     * @param self<TKey, TValue> $collection
     *
     * @return self<TKey, TValue>
     */
    public function udiff(callable $callback, self $collection): self
    {
        return new self(array_udiff($this->items, $collection->items(), $callback));
    }

    /**
     * @param self<TKey, TValue> $collection
     *
     * @return self<TKey, TValue>
     */
    public function udiffAssoc(callable $callback, self $collection): self
    {
        return new self(array_udiff_assoc($this->items, $collection->items(), $callback));
    }

    /**
     * @param self<TKey, TValue> $collection
     *
     * @return self<TKey, TValue>
     */
    public function udiffUassoc(callable $valueCallback, callable $keyCallback, self $collection): self
    {
        return new self(array_udiff_uassoc($this->items, $collection->items(), $valueCallback, $keyCallback));
    }

    /**
     * @param self<TKey, TValue> $collection
     *
     * @return self<TKey, TValue>
     */
    public function uintersect(callable $callback, self $collection): self
    {
        return new self(array_uintersect($this->items, $collection->items(), $callback));
    }

    /**
     * @param self<TKey, TValue> $collection
     *
     * @return self<TKey, TValue>
     */
    public function uintersectAssoc(callable $callback, self $collection): self
    {
        return new self(array_uintersect_assoc($this->items, $collection->items(), $callback));
    }

    /**
     * @param self<TKey, TValue> $collection
     *
     * @return self<TKey, TValue>
     */
    public function uintersectUassoc(callable $valueCallback, callable $keyCallback, self $collection): self
    {
        return new self(array_uintersect_uassoc($this->items, $collection->items(), $valueCallback, $keyCallback));
    }

    public function uksort(callable $callback): void
    {
        uksort($this->items, $callback);
    }

    public function unique(int $sortFlags = SORT_STRING): void
    {
        $this->items = array_unique($this->items, $sortFlags);
    }

    public function unshift(mixed ...$values): int
    {
        return array_unshift($this->items, ...$values);
    }

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

    public function walk(callable $callback, mixed $arg = null): void
    {
        array_walk($this->items, $callback, $arg);
    }

    public function walkRecursive(callable $callback, mixed $arg = null): void
    {
        array_walk_recursive($this->items, $callback, $arg);
    }
}
