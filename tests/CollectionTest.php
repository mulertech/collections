<?php

namespace MulerTech\Collections\Tests;

use MulerTech\Collections\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testAll(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertTrue($collection->all(fn($item) => $item <= 3));
    }

    public function testAny(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertTrue($collection->any(fn($item) => $item > 2));
        $this->assertFalse($collection->any(fn($item) => $item > 3));
    }

    public function testArsort(): void
    {
        $collection = new Collection([3, 1, 2]);
        $collection->arsort();
        $this->assertEquals([0 => 3, 2 => 2, 1 => 1], $collection->items());
    }

    public function testAsort(): void
    {
        $collection = new Collection([3, 1, 2]);
        $collection->asort();
        $this->assertEquals([1 => 1, 2 => 2, 0 => 3], $collection->items());
    }

    public function testChangeKeyCase(): void
    {
        $collection = new Collection(['a' => 1, 'B' => 2]);
        $collection->changeKeyCase(CASE_UPPER);
        $this->assertEquals(['A' => 1, 'B' => 2], $collection->items());
    }

    public function testChunk(): void
    {
        $collection = new Collection([1, 2, 3, 4]);
        $chunks = $collection->chunk(2);
        $this->assertEquals(
            [new Collection([1, 2]), new Collection([3, 4])],
            $chunks->items()
        );
        $noChunk = $collection->chunk(0);
        $this->assertEquals([], $noChunk->items());
    }

    public function testColumn(): void
    {
        $collection = new Collection([
            ['id' => 1, 'name' => 'John'],
            ['id' => 2, 'name' => 'Jane']
        ]);
        $this->assertEquals([1, 2], $collection->column('id')->items());
    }

    public function testCombine(): void
    {
        $collection = new Collection(['a', 'b']);
        $this->assertEquals(['a' => 1, 'b' => 2], $collection->combine(new Collection([1, 2]))->items());
    }

    public function testContainsWithStringValues(): void
    {
        $collection = new Collection(['apple', 'banana', 'cherry']);
        $this->assertTrue($collection->contains('banana'));
        $this->assertFalse($collection->contains('grape'));
    }

    public function testContainsWithObjectValues(): void
    {
        $object1 = (object)['id' => 1, 'name' => 'John'];
        $object2 = (object)['id' => 2, 'name' => 'Jane'];
        $collection = new Collection([$object1, $object2]);
        $this->assertTrue($collection->contains($object1));
        $this->assertFalse($collection->contains((object)['id' => 3, 'name' => 'Doe']));
    }

    public function testCount(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals(3, $collection->count());
    }

    public function testCountValues(): void
    {
        $collection = new Collection([1, 1, 2, 3, 3, 3]);
        $this->assertEquals([1 => 2, 2 => 1, 3 => 3], $collection->countValues()->items());
        $collection = new Collection(['a', 'b', 'b', 'c']);
        $this->assertEquals(['a' => 1, 'b' => 2, 'c' => 1], $collection->countValues()->items());
    }

    public function testCurrent(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals(1, $collection->current());
    }

    public function testDiff(): void
    {
        $collection = new Collection([1, 2, 3]);
        $diff = $collection->diff(new Collection([2, 3, 4]));
        $this->assertEquals([0 => 1], $diff->items());
    }

    public function testDiffAssoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $diff = $collection->diffAssoc(new Collection(['a' => 1, 'b' => 3]));
        $this->assertEquals(['b' => 2], $diff->items());
    }

    public function testDiffKey(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $diff = $collection->diffKey(new Collection(['a' => 3]));
        $this->assertEquals(['b' => 2], $diff->items());
    }

    public function testDiffUassoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $diff = $collection->diffUassoc(fn($a, $b) => $a <=> $b, new Collection(['a' => 1, 'b' => 3]));
        $this->assertEquals(['b' => 2], $diff->items());
    }

    public function testDiffUkey(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $diff = $collection->diffUkey(fn($a, $b) => $a <=> $b, new Collection(['a' => 3]));
        $this->assertEquals(['b' => 2], $diff->items());
    }

    public function testEnd(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals(3, $collection->end());
    }

    public function testExtract(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $this->assertEquals(2, $collection->extract());
    }

    public function testFill(): void
    {
        $collection = new Collection();
        $this->assertEquals(['a', 'a', 'a'], $collection->fill(0, 3, 'a')->items());
    }

    public function testFillKeys(): void
    {
        $collection = new Collection();
        $this->assertEquals(
            ['a' => 'value', 'b' => 'value'],
            $collection->fillKeys(['a', 'b'], 'value')->items()
        );
    }

    public function testFilter(): void
    {
        $collection = new Collection([1, 2, 3, 4]);
        $collection->filter(fn($item) => $item > 2);
        $this->assertEquals([2 => 3, 3 => 4], $collection->items());
    }

    public function testFind(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals(2, $collection->find(fn($item) => $item > 1));
    }

    public function testFindKey(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $this->assertEquals('b', $collection->findKey(fn($item) => $item > 1));
    }

    public function testFlip(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $this->assertEquals([1 => 'a', 2 => 'b'], $collection->flip()->items());
    }

    public function testGetIteratorForUseForeach(): void
    {
        $collection = new Collection([1, 2, 3]);
        $result = [];
        foreach ($collection as $key => $value) {
            $result[] = "Key: $key, Value: $value";
        }
        $this->assertEquals(
            ['Key: 0, Value: 1', 'Key: 1, Value: 2', 'Key: 2, Value: 3'],
            $result
        );
    }

    public function testInArray(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertTrue($collection->inArray(2));
        $this->assertFalse($collection->inArray(4));
    }

    public function testIntersect(): void
    {
        $collection = new Collection([1, 2, 3]);
        $intersect = $collection->intersect(new Collection([2, 3, 4]));
        $this->assertEquals([1 => 2, 2 => 3], $intersect->items());
    }

    public function testIntersectAssoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $intersect = $collection->intersectAssoc(new Collection(['a' => 1, 'b' => 3]));
        $this->assertEquals(['a' => 1], $intersect->items());
    }

    public function testIntersectKey(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $intersect = $collection->intersectKey(new Collection(['a' => 3]));
        $this->assertEquals(['a' => 1], $intersect->items());
    }

    public function testIntersectUassoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $intersect = $collection->intersectUassoc(fn($a, $b) => $a <=> $b, new Collection(['a' => 1, 'b' => 3]));
        $this->assertEquals(['a' => 1], $intersect->items());
    }

    public function testIntersectUkey(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $intersect = $collection->intersectUkey(fn($a, $b) => $a <=> $b, new Collection(['a' => 3]));
        $this->assertEquals(['a' => 1], $intersect->items());
    }

    public function testIsList(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertTrue($collection->isList());
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $this->assertFalse($collection->isList());
    }

    public function testItems(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals([1, 2, 3], $collection->items());
    }

    public function testKey(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $this->assertEquals('a', $collection->key());
    }

    public function testKeyExists(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $this->assertTrue($collection->keyExists('a'));
        $this->assertFalse($collection->keyExists('c'));
    }

    public function testKeyFirst(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $this->assertEquals('a', $collection->keyFirst());
    }

    public function testKeyLast(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $this->assertEquals('b', $collection->keyLast());
    }

    public function testKeys(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $this->assertEquals(['a', 'b'], $collection->keys()->items());
        $this->assertEquals(['a'], $collection->keys('1')->items());
        $this->assertEquals(['b'], $collection->keys(2, true)->items());
    }

    public function testKrsort(): void
    {
        $collection = new Collection(['a' => 1, 'c' => 3, 'b' => 2]);
        $collection->krsort();
        $this->assertEquals(['c' => 3, 'b' => 2, 'a' => 1], $collection->items());
    }

    public function testKsort(): void
    {
        $collection = new Collection(['a' => 1, 'c' => 3, 'b' => 2]);
        $collection->ksort();
        $this->assertEquals(['a' => 1, 'b' => 2, 'c' => 3], $collection->items());
    }

    public function testMap(): void
    {
        $collection = new Collection([1, 2, 3]);
        $collection->map(fn($item) => $item * 2);
        $this->assertEquals([2, 4, 6], $collection->items());
    }

    public function testMerge(): void
    {
        $collection = new Collection([1, 2]);
        $collection->merge(new Collection([3, 4]));
        $this->assertEquals([1, 2, 3, 4], $collection->items());
    }

    public function testMergeRecursive(): void
    {
        $collection = new Collection(['a' => 1, 'b' => ['x' => 2]]);
        $collection->mergeRecursive(new Collection(['b' => ['y' => 3], 'c' => 4]));
        $this->assertEquals(['a' => 1, 'b' => ['x' => 2, 'y' => 3], 'c' => 4], $collection->items());
    }

    public function testMultisort(): void
    {
        $collection = new Collection([3, 1, 2]);
        $collection->multisort();
        $this->assertEquals([1, 2, 3], $collection->items());
    }

    public function testNatcasesort(): void
    {
        $collection = new Collection(['IMG0.png', 'img12.png', 'img10.png', 'img2.png', 'img1.png', 'IMG3.png']);
        $collection->natcasesort();
        $this->assertEquals(
            [0 => 'IMG0.png', 4 => 'img1.png', 3 => 'img2.png', 5 => 'IMG3.png', 2 => 'img10.png', 1 => 'img12.png'],
            $collection->items()
        );
    }

    public function testNatsort(): void
    {
        $collection = new Collection(['img12.png', 'img10.png', 'img2.png', 'img1.png']);
        $collection->natsort();
        $this->assertEquals(
            [3 => 'img1.png', 2 => 'img2.png', 1 => 'img10.png', 0 => 'img12.png'],
            $collection->items()
        );
    }

    public function testNext(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals(2, $collection->next());
    }

    public function testOffsetExists(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertTrue($collection->offsetExists(1));
        $this->assertFalse($collection->offsetExists(3));
    }

    public function testOffsetGet(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals(2, $collection->offsetGet(1));
    }

    public function testOffsetSet(): void
    {
        $collection = new Collection([1, 2, 3]);
        $collection->offsetSet(1, 4);
        $this->assertEquals([1, 4, 3], $collection->items());
        $collection = new Collection([1, 2, 3]);
        $collection->offsetSet(null, 4);
        $this->assertEquals([1, 2, 3, 4], $collection->items());
    }

    public function testOffsetUnset(): void
    {
        $collection = new Collection([1, 2, 3]);
        $collection->offsetUnset(1);
        $this->assertEquals([0 => 1, 2 => 3], $collection->items());
    }

    public function testPad(): void
    {
        $collection = new Collection([1, 2]);
        $collection->pad(4, 0);
        $this->assertEquals([1, 2, 0, 0], $collection->items());
    }

    public function testPop(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals(3, $collection->pop());
        $this->assertEquals([1, 2], $collection->items());
    }

    public function testPrev(): void
    {
        $collection = new Collection([1, 2, 3]);
        $collection->next();
        $this->assertEquals(1, $collection->prev());
    }

    public function testProduct(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals(6, $collection->product());
    }

    public function testPush(): void
    {
        $collection = new Collection([1, 2]);
        $collection->push(3, 4);
        $this->assertEquals([1, 2, 3, 4], $collection->items());
    }

    public function testRand(): void
    {
        $collection = new Collection(['Neo', 'Morpheus', 'Trinity']);
        $this->assertContains($collection->rand(), [0, 1, 2]);
        $this->assertContains($collection->rand(2)[0], [0, 1, 2]);
    }

    public function testRange(): void
    {
        $collection = new Collection();
        $this->assertEquals([1, 2, 3], $collection->range(1, 3)->items());
    }

    public function testReduce(): void
    {
        $collection = new Collection([1, 2, 3]);
        $sum = $collection->reduce(fn($carry, $item) => $carry + $item, 0);
        $this->assertEquals(6, $sum);
    }

    public function testRemove(): void
    {
        $collection = new Collection([1, 2, 3]);
        $collection->remove(1);
        $this->assertEquals([0 => 1, 2 => 3], $collection->items());
        // Test removing a non-existent key
        $collection->remove(1);
    }

    public function testRemoveItem(): void
    {
        // Test with integers
        $collection = new Collection([1, 2, 3, 2]);
        $this->assertTrue($collection->removeItem(2));
        $this->assertEquals([0 => 1, 2 => 3, 3 => 2], $collection->items());
        
        // Test with strings
        $collection = new Collection(['apple', 'banana', 'cherry']);
        $this->assertTrue($collection->removeItem('banana'));
        $this->assertEquals([0 => 'apple', 2 => 'cherry'], $collection->items());
        $this->assertFalse($collection->removeItem('grape'));
        
        // Test with objects
        $obj1 = new \stdClass();
        $obj1->id = 1;
        $obj2 = new \stdClass();
        $obj2->id = 2;
        $obj3 = new \stdClass();
        $obj3->id = 3;
        
        $collection = new Collection([$obj1, $obj2, $obj3]);
        $this->assertTrue($collection->removeItem($obj2));
        $this->assertEquals([0 => $obj1, 2 => $obj3], $collection->items());
        
        // Test with non-strict comparison
        $collection = new Collection([1, '2', 3]);
        $this->assertFalse($collection->removeItem(2));
        $this->assertTrue($collection->removeItem(2, false));
        $this->assertEquals([0 => 1, 2 => 3], $collection->items());
    }

    public function testReplace(): void
    {
        $collection = new Collection([1, 2, 3]);
        $collection->replace(new Collection([4, 5]));
        $this->assertEquals([4, 5, 3], $collection->items());
    }

    public function testReplaceRecursive(): void
    {
        $collection = new Collection(['a' => 1, 'b' => ['x' => 2]]);
        $collection->replaceRecursive(new Collection(['b' => ['y' => 3], 'c' => 4]));
        $this->assertEquals(['a' => 1, 'b' => ['y' => 3, 'x' => 2], 'c' => 4], $collection->items());
    }

    public function testReset(): void
    {
        $collection = new Collection([1, 2, 3]);
        $collection->next();
        $this->assertEquals(1, $collection->reset());
    }

    public function testReverse(): void
    {
        $collection = new Collection([1, 2, 3]);
        $collection->reverse();
        $this->assertEquals([3, 2, 1], $collection->items());
    }

    public function testRsort(): void
    {
        $collection = new Collection([3, 1, 2]);
        $collection->rsort();
        $this->assertEquals([3, 2, 1], $collection->items());
    }

    public function testSearch(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals(1, $collection->search(2));
        $this->assertFalse($collection->search(4));
    }

    public function testShift(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals(1, $collection->shift());
        $this->assertEquals([2, 3], $collection->items());
    }

    public function testShuffle(): void
    {
        $collection = new Collection([1, 2, 3]);
        $collection->shuffle();
        $this->assertCount(3, $collection->items());
    }

    public function testSlice(): void
    {
        $collection = new Collection([1, 2, 3, 4]);
        $slice = $collection->slice(1, 2);
        $this->assertEquals([2, 3], $slice->items());
    }

    public function testSort(): void
    {
        $collection = new Collection([3, 1, 2]);
        $collection->sort();
        $this->assertEquals([1, 2, 3], $collection->items());
    }

    public function testSplice(): void
    {
        $collection = new Collection([1, 2, 3, 4]);
        $collection->splice(1, 2, [5, 6]);
        $this->assertEquals([1, 5, 6, 4], $collection->items());
    }

    public function testSum(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals(6, $collection->sum());
    }

    public function testUasort(): void
    {
        $collection = new Collection(['a' => 8, 'b' => -1, 'c' => 2]);
        $collection->uasort(function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        });
        $this->assertEquals(['b' => -1, 'c' => 2, 'a' => 8], $collection->items());
    }

    public function testUdiff(): void
    {
        $collection = new Collection([1, 2, 3]);
        $diff = $collection->udiff(fn($a, $b) => $a <=> $b, new Collection([2, 3, 4]));
        $this->assertEquals([0 => 1], $diff->items());
    }

    public function testUdiffAssoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $diff = $collection->udiffAssoc(fn($a, $b) => $a <=> $b, new Collection(['a' => 1, 'b' => 3]));
        $this->assertEquals(['b' => 2], $diff->items());
    }

    public function testUdiffUassoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $diff = $collection->udiffUassoc(
            fn($a, $b) => $a <=> $b,
            fn($a, $b) => $a <=> $b,
            new Collection(['a' => 1, 'b' => 3])
        );
        $this->assertEquals(['b' => 2], $diff->items());
    }

    public function testUintersect(): void
    {
        $collection = new Collection([1, 2, 3]);
        $intersect = $collection->uintersect(fn($a, $b) => $a <=> $b, new Collection([2, 3, 4]));
        $this->assertEquals([1 => 2, 2 => 3], $intersect->items());
    }

    public function testUintersertAssoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $intersect = $collection->uintersectAssoc(fn($a, $b) => $a <=> $b, new Collection(['a' => 1, 'b' => 3]));
        $this->assertEquals(['a' => 1], $intersect->items());
    }

    public function testUintersertUassoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $intersect = $collection->uintersectUassoc(
            fn($a, $b) => $a <=> $b,
            fn($a, $b) => $a <=> $b,
            new Collection(['a' => 1, 'b' => 3])
        );
        $this->assertEquals(['a' => 1], $intersect->items());
    }

    public function testUksort(): void
    {
        $collection = new Collection(['a' => 1, 'c' => 3, 'b' => 2]);
        $collection->uksort(fn($a, $b) => $a <=> $b);
        $this->assertEquals(['a' => 1, 'b' => 2, 'c' => 3], $collection->items());
    }

    public function testUnique(): void
    {
        $collection = new Collection([1, 2, 2, 3]);
        $collection->unique();
        $this->assertEquals([0 => 1, 1 => 2, 3 => 3], $collection->items());
    }

    public function testUnshift(): void
    {
        $collection = new Collection([1, 2]);
        $collection->unshift(3, 4);
        $this->assertEquals([3, 4, 1, 2], $collection->items());
    }

    public function testUsort(): void
    {
        $collection = new Collection([3, 1, 2]);
        $collection->usort(fn($a, $b) => $a <=> $b);
        $this->assertEquals([1, 2, 3], $collection->items());
    }

    public function testValues(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $this->assertEquals([1, 2], $collection->values()->items());
    }

    public function testWalk(): void
    {
        $collection = new Collection([1, 2, 3]);
        $collection->walk(fn(&$item) => $item *= 2);
        $this->assertEquals([2, 4, 6], $collection->items());
    }

    public function testWalkRecursive(): void
    {
        $collection = new Collection(['a' => 1, 'b' => ['x' => 2]]);
        $collection->walkRecursive(fn(&$item) => $item *= 2);
        $this->assertEquals(['a' => 2, 'b' => ['x' => 4]], $collection->items());
    }
}

