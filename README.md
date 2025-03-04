# Collections

___
[![Latest Version on Packagist](https://img.shields.io/packagist/v/mulertech/collections.svg?style=flat-square)](https://packagist.org/packages/mulertech/collections)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mulertech/collections/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mulertech/collections/actions/workflows/tests.yml)
[![GitHub PHPStan Action Status](https://img.shields.io/github/actions/workflow/status/mulertech/collections/phpstan.yml?branch=main&label=phpstan&style=flat-square)](https://github.com/mulertech/collections/actions/workflows/phpstan.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/mulertech/collections.svg?style=flat-square)](https://packagist.org/packages/mulertech/collections)
[![Test Coverage](https://raw.githubusercontent.com/mulertech/collections/main/badge-coverage.svg)](https://packagist.org/packages/mulertech/collections)
___

This is a simple collections package for PHP. It provides a set of methods to work with arrays in a more functional way.

## Installation

###### _Two methods to install Collections package with composer :_

1.
Add to your "**composer.json**" file into require section :

```
"mulertech/collections": "^1.0"
```

and run the command :

```
php composer.phar update
```

2.
Run the command :

```
php composer.phar require mulertech/collections "^1.0"
```

___

## Usage

__construct(array $items = []) : Initializes a new collection with the provided items.

```php
$collection = new Collection([1, 2, 3, 4, 5]);
```

all(callable $callback): bool : Checks if all items in the collection satisfy the callback.

```php
$collection = new Collection([1, 2, 3]);
$collection->all(fn ($item) => $item <= 3); // true
```

any(callable $callback): bool : Checks if at least one item in the collection satisfies the callback.

```php
$collection = new Collection([1, 2, 3]);
$collection->any(fn ($item) => $item === 2); // true
```

arsort(int $sortFlags = SORT_REGULAR): void : Sorts the items in the collection in descending order while maintaining key association.

```php
$collection = new Collection([3, 1, 2]);
$collection->arsort();
$collection->items(); // [0 => 3, 2 => 2, 1 => 1]
```

asort(int $sortFlags = SORT_REGULAR): void : Sorts the items in the collection in ascending order while maintaining key association.

```php
$collection = new Collection([3, 1, 2]);
$collection->asort();
$collection->items(); // [1 => 1, 2 => 2, 0 => 3]
```

changeKeyCase(int $case = CASE_LOWER): void : Changes the case of all keys in the collection.

```php
$collection = new Collection(['a' => 1, 'B' => 2]);
$collection->changeKeyCase(CASE_UPPER);
$collection->items(); // ['A' => 1, 'B' => 2]
```

chunk(int $length, bool $preserveKeys = false): array : Splits the collection into chunks of the specified size.

```php
$collection = new Collection([1, 2, 3, 4]);
$collection->chunk(2); // [[1, 2], [3, 4]]
```

column(int|string|null $columnKey, int|string|null $indexKey = null): array : Returns the values from a single column of the collection.

```php
$collection = new Collection([
    ['id' => 1, 'name' => 'John'],
    ['id' => 2, 'name' => 'Jane']
]);
$collection->column('name'); // ['John', 'Jane']
```

combine(array $keys, array $values): void : Creates a new collection using the provided keys and values.

```php
$collection = new Collection();
$collection->combine(['a', 'b'], [1, 2]);
$collection->items(); // ['a' => 1, 'b' => 2]
```

contains(mixed $value): bool : Checks if a value exists in the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->contains(2); // true
```

count(int $mode = COUNT_NORMAL): int : Counts the number of items in the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->count(); // 3
```

countValues(): array : Counts the values of the collection.

```php
$collection = new Collection([1, 1, 2, 3, 3, 3]);
$collection->countValues(); // [1 => 2, 2 => 1, 3 => 3]
```

current(): mixed : Returns the current item in the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->current(); // 1
```

diff(array ...$arrays): array : Computes the difference between the collection and the provided arrays.

```php
$collection = new Collection([1, 2, 3]);
$collection->diff([2, 3, 4]); // [0 => 1]
```

diffAssoc(array ...$arrays): array : Computes the difference with the provided arrays by comparing keys and values.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->diffAssoc(['a' => 1, 'b' => 3]); // ['b' => 2]
```

diffKey(array ...$arrays): array : Computes the difference with the provided arrays by comparing only keys.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->diffKey(['a' => 3]); // ['b' => 2]
```

diffUassoc(callable $callback, array ...$arrays): array : Computes the difference with the provided arrays using a callback function for keys.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->diffUassoc(fn ($a, $b) => $a <=> $b, ['a' => 1, 'b' => 3]); // ['b' => 2]
```

diffUkey(callable $callback, array ...$arrays): array : Computes the difference with the provided arrays using a callback function for keys.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->diffUkey(fn ($a, $b) => $a <=> $b, ['a' => 3]); // ['b' => 2]
```

end(): mixed : Returns the last item in the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->end(); // 3
```

extract(int $flags = EXTR_OVERWRITE, string $prefix = ''): int : Extracts variables from the collection.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->extract(); // 2
```

fill(int $startIndex, int $count, mixed $value): void : Fills the collection with a specified value.

```php
$collection = new Collection();
$collection->fill(0, 3, 'a');
$collection->items(); // ['a', 'a', 'a']
```

fillKeys(array $keys, mixed $value): void : Fills the collection with the specified keys and value.

```php
$collection = new Collection();
$collection->fillKeys(['a', 'b'], 'value');
$collection->items(); // ['a' => 'value', 'b' => 'value']
```

filter(?callable $callback = null, int $mode = 0): void : Filters the items in the collection using a callback.

```php
$collection = new Collection([1, 2, 3, 4]);
$collection->filter(fn ($item) => $item > 2);
$collection->items(); // [2 => 3, 3 => 4]
```

find(callable $callback): mixed : Finds the first item that satisfies the callback.

```php
$collection = new Collection([1, 2, 3]);
$collection->find(fn ($item) => $item >= 2); // 2
```

findKey(callable $callback): mixed : Finds the key of the first item that satisfies the callback.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->findKey(fn ($item) => $item >= 2); // 'b'
```

flip(): void : Exchanges the keys and values of the collection.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->flip();
$collection->items(); // [1 => 'a', 2 => 'b']
```

inArray(mixed $needle, bool $strict = false): bool : Checks if a value exists in the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->inArray(2); // true
```

intersect(array ...$arrays): array : Computes the intersection of the collection with the provided arrays.

```php
$collection = new Collection([1, 2, 3]);
$collection->intersect([2, 3, 4]); // [1 => 2, 2 => 3]
```

intersectAssoc(array ...$arrays): array : Computes the intersection with the provided arrays by comparing keys and values.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->intersectAssoc(['a' => 1, 'b' => 3]); // ['a' => 1]
```

intersectKey(array ...$arrays): array : Computes the intersection with the provided arrays by comparing only keys.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->intersectKey(['a' => 3]); // ['a' => 1]
```

intersectUassoc(callable $callback, array ...$arrays): array : Computes the intersection with the provided arrays using a callback function for keys.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->intersectUassoc(fn ($a, $b) => $a <=> $b, ['a' => 1, 'b' => 3]); // ['a' => 1]
```

intersectUkey(callable $callback, array ...$arrays): array : Computes the intersection with the provided arrays using a callback function for keys.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->intersectUkey(fn ($a, $b) => $a <=> $b, ['a' => 3]); // ['a' => 1]
```

isList(): bool : Checks if the collection is a list.

```php
$collection = new Collection([1, 2, 3]);
$collection->isList(); // true
```

items(): array : Returns the items in the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->items(); // [1, 2, 3]
```

key(): int|string|null : Returns the key of the current item.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->key(); // 'a'
```

keyExists(mixed $key): bool : Checks if a key exists in the collection.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->keyExists('b'); // true
```

keyFirst(): int|string|null : Returns the first key of the collection.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->keyFirst(); // 'a'
```

keyLast(): int|string|null : Returns the last key of the collection.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->keyLast(); // 'b'
```

keys(mixed $filterValue = null, bool $strict = false): array : Returns all keys in the collection.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->keys(); // ['a', 'b']
```

krsort(int $sortFlags = SORT_REGULAR): void : Sorts the keys of the collection in descending order.

```php
$collection = new Collection(['a' => 1, 'c' => 3, 'b' => 2]);
$collection->krsort();
$collection->items(); // ['c' => 3, 'b' => 2, 'a' => 1]
```

ksort(int $sortFlags = SORT_REGULAR): void : Sorts the keys of the collection in ascending order.

```php
$collection = new Collection(['a' => 1, 'c' => 3, 'b' => 2]);
$collection->ksort();
$collection->items(); // ['a' => 1, 'b' => 2, 'c' => 3]
```

map(callable $callback, array ...$arrays): void : Applies a function to each item in the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->map(fn ($item) => $item * 2);
$collection->items(); // [2, 4, 6]
```

merge(array ...$arrays): void : Merges the collection with the provided arrays.

```php
$collection = new Collection([1, 2]);
$collection->merge([3, 4]);
$collection->items(); // [1, 2, 3, 4]
```

mergeRecursive(array ...$arrays): void : Recursively merges the collection with the provided arrays.

```php
$collection = new Collection(['a' => 1, 'b' => ['x' => 2]]);
$collection->mergeRecursive(['b' => ['y' => 3], 'c' => 4]);
$collection->items(); // ['a' => 1, 'b' => ['x' => 2, 'y' => 3], 'c' => 4]
```

multisort(mixed $sortOrder = SORT_ASC, mixed $sortFlags = SORT_REGULAR, mixed ...$rest): void : Sorts the collection using multiple criteria.

```php
$collection = new Collection([3, 1, 2]);
$collection->multisort(SORT_DESC);
$collection->items(); // [3, 2, 1]
```

natcasesort(): void : Sorts the collection using a case-insensitive natural order algorithm.

```php
$collection = new Collection(['IMG0.png', 'img12.png', 'img10.png', 'img2.png', 'img1.png', 'IMG3.png']);
$collection->natcasesort();
$collection->items(); // ['IMG0.png', 'img1.png', 'img2.png', 'IMG3.png', 'img10.png', 'img12.png']
```

natsort(): void : Sorts the collection using a natural order algorithm.

```php
$collection = new Collection(['img12.png', 'img10.png', 'img2.png', 'img1.png']);
$collection->natsort();
$collection->items(); // ['img1.png', 'img2.png', 'img10.png', 'img12.png']
```

next(): mixed : Advances the internal pointer of the collection and returns the next item.

```php
$collection = new Collection([1, 2, 3]);
$collection->next(); // 2
```

pad(int $length, mixed $value): void : Pads the collection to the specified length with a value.

```php
$collection = new Collection([1, 2]);
$collection->pad(4, 0);
$collection->items(); // [1, 2, 0, 0]
```

pop(): mixed : Pops and returns the last item of the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->pop(); // 3
```

prev(): mixed : Rewinds the internal pointer of the collection and returns the previous item.

```php
$collection = new Collection([1, 2, 3]);
$collection->next();
$collection->prev(); // 1
```

product(): int|float : Computes the product of the values in the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->product(); // 6
```

push(mixed ...$values): void : Pushes one or more items onto the end of the collection.

```php
$collection = new Collection([1, 2]);
$collection->push(3, 4);
$collection->items(); // [1, 2, 3, 4]
```

rand(int $num = 1): int|string|array : Selects one or more random items from the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->rand(); // 1 or 2 or 3
```

range(string|int|float $start, string|int|float $end, int|float $step = 1): void : Creates a collection containing a range of elements.

```php
$collection = new Collection();
$collection->range(1, 3);
$collection->items(); // [1, 2, 3]
```

reduce(callable $callback, mixed $initial = null): mixed : Reduces the collection to a single value using a callback.

```php
$collection = new Collection([1, 2, 3]);
$collection->reduce(fn ($carry, $item) => $carry + $item); // 6
```

replace(array ...$replacements): void : Replaces the items in the collection with the items from the provided arrays.

```php
$collection = new Collection([1, 2, 3]);
$collection->replace([4, 5]);
$collection->items(); // [4, 5, 3]
```

replaceRecursive(array ...$replacements): void : Recursively replaces the items in the collection with the items from the provided arrays.

```php
$collection = new Collection(['a' => 1, 'b' => ['x' => 2]]);
$collection->replaceRecursive(['b' => ['y' => 3], 'c' => 4]);
$collection->items(); // ['a' => 1, 'b' => ['y' => 3, 'x' => 2], 'c' => 4]
```

reset(): mixed : Resets the internal pointer of the collection and returns the first item.

```php
$collection = new Collection([1, 2, 3]);
$collection->next();
$collection->reset(); // 1
```

reverse(bool $preserveKeys = false): void : Reverses the order of the items in the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->reverse();
$collection->items(); // [3, 2, 1]
```

rsort(int $sortFlags = SORT_REGULAR): void : Sorts the collection in descending order.

```php
$collection = new Collection([3, 1, 2]);
$collection->rsort();
$collection->items(); // [3, 2, 1]
```

search(mixed $needle, bool $strict = false): int|string|false : Searches for a value in the collection and returns the corresponding key.

```php
$collection = new Collection([1, 2, 3]);
$collection->search(2); // 1
```

shift(): mixed : Shifts and returns the first item of the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->shift(); // 1
```

shuffle(): void : Shuffles the items in the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->shuffle();
$collection->items(); // [2, 1, 3] for example
```

slice(int $offset, ?int $length = null, bool $preserveKeys = false): array : Extracts a slice of the collection.

```php
$collection = new Collection([1, 2, 3, 4]);
$collection->slice(1, 2); // [2, 3]
```

sort(int $sortFlags = SORT_REGULAR): void : Sorts the collection in ascending order.

```php
$collection = new Collection([3, 1, 2]);
$collection->sort();
$collection->items(); // [1, 2, 3]
```

splice(int $offset, ?int $length = null, mixed $replacement = []): void : Removes a portion of the collection and replaces it with the provided items.

```php
$collection = new Collection([1, 2, 3, 4]);
$collection->splice(1, 2, [5, 6]);
$collection->items(); // [1, 5, 6, 4]
```

sum(): int|float : Computes the sum of the values in the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->sum(); // 6
```

uasort(callable $callback): void : Sorts the collection using a user-defined comparison function.

```php
$collection = new Collection(['a' => 8, 'b' => -1, 'c' => 2]);
$collection->uasort(function ($a, $b) {
    if ($a === $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
});
$collection->items(); // ['b' => -1, 'c' => 2, 'a' => 8]
```

udiff(callable $callback, array ...$arrays): array : Computes the difference between the collection and the provided arrays using a callback function.

```php
$collection = new Collection([1, 2, 3]);
$collection->udiff(fn ($a, $b) => $a <=> $b, [2, 3, 4]); // [0 => 1]
```

udiffAssoc(callable $callback, array ...$arrays): array : Computes the difference with the provided arrays using a callback function for values.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->udiffAssoc(fn ($a, $b) => $a <=> $b, ['a' => 1, 'b' => 3]); // ['b' => 2]
```

udiffUassoc(callable $valueCallback, callable $keyCallback, array ...$arrays): array : Computes the difference with the provided arrays using callback functions for values and keys.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->udiffUassoc(fn ($a, $b) => $a <=> $b, fn ($a, $b) => $a <=> $b, ['a' => 1, 'b' => 3]); // ['b' => 2]
```

uintersect(callable $callback, array ...$arrays): array : Computes the intersection of the collection with the provided arrays using a callback function.

```php
$collection = new Collection([1, 2, 3]);
$collection->uintersect(fn ($a, $b) => $a <=> $b, [2, 3, 4]); // [1 => 2, 2 => 3]
```

uintersectAssoc(callable $callback, array ...$arrays): array : Computes the intersection with the provided arrays using a callback function for values.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->uintersectAssoc(fn ($a, $b) => $a <=> $b, ['a' => 1, 'b' => 3]); // ['a' => 1]
```

uintersectUassoc(callable $valueCallback, callable $keyCallback, array ...$arrays): array : Computes the intersection with the provided arrays using callback functions for values and keys.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->uintersectUassoc(fn ($a, $b) => $a <=> $b, fn ($a, $b) => $a <=> $b, ['a' => 1, 'b' => 3]); // ['a' => 1]
```

uksort(callable $callback): void : Sorts the collection by keys using a user-defined comparison function.

```php
$collection = new Collection(['a' => 1, 'c' => 3, 'b' => 2]);
$collection->uksort(fn ($a, $b) => $a <=> $b);
$collection->items(); // ['a' => 1, 'b' => 2, 'c' => 3]
```

unique(int $sortFlags = SORT_STRING): void : Removes duplicate values from the collection.

```php
$collection = new Collection([1, 2, 2, 3]);
$collection->unique();
$collection->items(); // [1, 2, 3]
```

unshift(mixed ...$values): int : Unshifts one or more items onto the beginning of the collection.

```php
$collection = new Collection([1, 2]);
$collection->unshift(3, 4);
$collection->items(); // [3, 4, 1, 2]
```

usort(callable $callback): void : Sorts the collection using a user-defined comparison function.

```php
$collection = new Collection([3, 1, 2]);
$collection->usort(fn ($a, $b) => $a <=> $b);
$collection->items(); // [1, 2, 3]
```

values(): array : Returns all values in the collection.

```php
$collection = new Collection(['a' => 1, 'b' => 2]);
$collection->values(); // [1, 2]
```

walk(callable $callback, mixed $arg = null): void : Applies a function to each item in the collection.

```php
$collection = new Collection([1, 2, 3]);
$collection->walk(fn (&$item) => $item *= 2);
$collection->items(); // [2, 4, 6]
```

walkRecursive(callable $callback, mixed $arg = null): void : Recursively applies a function to each item in the collection.

```php
$collection = new Collection(['a' => 1, 'b' => ['x' => 2]]);
$collection->walkRecursive(fn (&$item) => $item *= 2);
$collection->items(); // ['a' => 2, 'b' => ['x' => 4]]
```
