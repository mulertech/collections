<?php

namespace MulerTech\Collections;

class Collection
{
    public function __construct(private array $items = [])
    {}

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

    public function chunk(int $length, bool $preserveKeys = false): array
    {
        return array_chunk($this->items, $length, $preserveKeys);
    }

    public function column(int|string|null $columnKey, int|string|null $indexKey = null): array
    {
        return array_column($this->items, $columnKey, $indexKey);
    }

    public function combine(array $keys, array $values): void
    {
        $this->items = array_combine($keys, $values);
    }

    public function count(int $mode = COUNT_NORMAL): int
    {
        return count($this->items, $mode);
    }

    public function countValues(): array
    {
        return array_count_values($this->items);
    }

    public function current(): mixed
    {
        return current($this->items);
    }

    public function diff(array ...$arrays): array
    {
        return array_diff($this->items, ...$arrays);
    }

    public function diffAssoc(array ...$arrays): array
    {
        return array_diff_assoc($this->items, ...$arrays);
    }

    public function diffKey(array ...$arrays): array
    {
        return array_diff_key($this->items, ...$arrays);
    }

    public function diffUassoc(callable $callback, array ...$arrays): array
    {
        return array_diff_uassoc(...[$this->items, ...$arrays, $callback]);
    }

    public function diffUkey(callable $callback, array ...$arrays): array
    {
        return array_diff_ukey(...[$this->items, ...$arrays, $callback]);
    }

    public function end(): mixed
    {
        return end($this->items);
    }

    public function extract(int $flags = EXTR_OVERWRITE, string $prefix = ''): int
    {
        return extract($this->items, $flags, $prefix);
    }

    public function fill(int $startIndex, int $count, mixed $value): void
    {
        $this->items = array_fill($startIndex, $count, $value);
    }

    public function fillKeys(array $keys, mixed $value): void
    {
        $this->items = array_fill_keys($keys, $value);
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

    public function flip(): void
    {
        $this->items = array_flip($this->items);
    }

    public function inArray(mixed $needle, bool $strict = false): bool
    {
        return in_array($needle, $this->items, $strict);
    }

    public function intersect(array ...$arrays): array
    {
        return array_intersect($this->items, ...$arrays);
    }

    public function intersectAssoc(array ...$arrays): array
    {
        return array_intersect_assoc($this->items, ...$arrays);
    }

    public function intersectKey(array ...$arrays): array
    {
        return array_intersect_key($this->items, ...$arrays);
    }

    public function intersectUassoc(callable $callback, array ...$arrays): array
    {
        return array_intersect_uassoc(...[$this->items, ...$arrays, $callback]);
    }

    public function intersectUkey(callable $callback, array ...$arrays): array
    {
        return array_intersect_ukey(...[$this->items, ...$arrays, $callback]);
    }

    public function isList(): bool
    {
        return array_is_list($this->items);
    }

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

    public function keys(mixed $filterValue = null, bool $strict = false): array
    {
        if ($filterValue === null) {
            return array_keys($this->items);
        }

        return array_keys($this->items, $filterValue, $strict);
    }

    public function krsort(int $sortFlags = SORT_REGULAR): void
    {
        krsort($this->items, $sortFlags);
    }

    public function ksort(int $sortFlags = SORT_REGULAR): void
    {
        ksort($this->items, $sortFlags);
    }

    public function map(callable $callback, array ...$arrays): void
    {
        $this->items = array_map($callback, $this->items, ...$arrays);
    }

    public function merge(array ...$arrays): void
    {
        $this->items = array_merge($this->items, ...$arrays);
    }

    public function mergeRecursive(array ...$arrays): void
    {
        $this->items = array_merge_recursive($this->items, ...$arrays);
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

    public function rand(int $num = 1): int|string|array
    {
        return array_rand($this->items, $num);
    }

    public function range(string|int|float $start, string|int|float $end, int|float $step = 1): void
    {
        $this->items = range($start, $end, $step);
    }

    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        return array_reduce($this->items, $callback, $initial);
    }

    public function replace(array ...$replacements): void
    {
        $this->items = array_replace($this->items, ...$replacements);
    }

    public function replaceRecursive(array ...$replacements): void
    {
        $this->items = array_replace_recursive($this->items, ...$replacements);
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

    public function slice(int $offset, ?int $length = null, bool $preserveKeys = false): array
    {
        return array_slice($this->items, $offset, $length, $preserveKeys);
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

    public function udiff(callable $callback, array ...$arrays): array
    {
        return array_udiff(...[$this->items, ...$arrays, $callback]);
    }

    public function udiffAssoc(callable $callback, array ...$arrays): array
    {
        return array_udiff_assoc(...[$this->items, ...$arrays, $callback]);
    }

    public function udiffUassoc(callable $valueCallback, callable $keyCallback, array ...$arrays): array
    {
        return array_udiff_uassoc(...[$this->items, ...$arrays, $valueCallback, $keyCallback]);
    }

    public function uintersect(callable $callback, array ...$arrays): array
    {
        return array_uintersect(...[$this->items, ...$arrays, $callback]);
    }

    public function uintersectAssoc(callable $callback, array ...$arrays): array
    {
        return array_uintersect_assoc(...[$this->items, ...$arrays, $callback]);
    }

    public function uintersectUassoc(callable $valueCallback, callable $keyCallback, array ...$arrays): array
    {
        return array_uintersect_uassoc(...[$this->items, ...$arrays, $valueCallback, $keyCallback]);
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

    public function values(): array
    {
        return array_values($this->items);
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