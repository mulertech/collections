<?php

use PHPUnit\Framework\TestCase;
use MulerTech\Collections\Collection;

class CollectionTest extends TestCase
{
    public function testAll(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals(true, $collection->all(fn($item) => $item <= 3));
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
        $this->assertEquals([[1, 2], [3, 4]], $chunks);
    }

    public function testColumn(): void
    {
        $collection = new Collection([
            ['id' => 1, 'name' => 'John'],
            ['id' => 2, 'name' => 'Jane']
        ]);
        $this->assertEquals([1, 2], $collection->column('id'));
    }

    public function testCombine(): void
    {
        $collection = new Collection();
        $collection->combine(['a', 'b'], [1, 2]);
        $this->assertEquals(['a' => 1, 'b' => 2], $collection->items());
    }

    public function testCount(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals(3, $collection->count());
    }

    public function testCountValues(): void
    {
        $collection = new Collection([1, 1, 2, 3, 3, 3]);
        $this->assertEquals([1 => 2, 2 => 1, 3 => 3], $collection->countValues());
    }

    public function testCurrent(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertEquals(1, $collection->current());
    }

    public function testDiff(): void
    {
        $collection = new Collection([1, 2, 3]);
        $diff = $collection->diff([2, 3, 4]);
        $this->assertEquals([0 => 1], $diff);
    }

    public function testDiffAssoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $diff = $collection->diffAssoc(['a' => 1, 'b' => 3]);
        $this->assertEquals(['b' => 2], $diff);
    }

    public function testDiffKey(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $diff = $collection->diffKey(['a' => 3]);
        $this->assertEquals(['b' => 2], $diff);
    }

    public function testDiffUassoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $diff = $collection->diffUassoc(fn($a, $b) => $a <=> $b, ['a' => 1, 'b' => 3]);
        $this->assertEquals(['b' => 2], $diff);
    }

    public function testDiffUkey(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $diff = $collection->diffUkey(fn($a, $b) => $a <=> $b, ['a' => 3]);
        $this->assertEquals(['b' => 2], $diff);
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
        $collection->fill(0, 3, 'a');
        $this->assertEquals(['a', 'a', 'a'], $collection->items());
    }

    public function testFillKeys(): void
    {
        $collection = new Collection();
        $collection->fillKeys(['a', 'b'], 'value');
        $this->assertEquals(['a' => 'value', 'b' => 'value'], $collection->items());
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
        $collection->flip();
        $this->assertEquals([1 => 'a', 2 => 'b'], $collection->items());
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
        $intersect = $collection->intersect([2, 3, 4]);
        $this->assertEquals([1 => 2, 2 => 3], $intersect);
    }

    public function testIntersectAssoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $intersect = $collection->intersectAssoc(['a' => 1, 'b' => 3]);
        $this->assertEquals(['a' => 1], $intersect);
    }

    public function testIntersectKey(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $intersect = $collection->intersectKey(['a' => 3]);
        $this->assertEquals(['a' => 1], $intersect);
    }

    public function testIntersectUassoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $intersect = $collection->intersectUassoc(fn($a, $b) => $a <=> $b, ['a' => 1, 'b' => 3]);
        $this->assertEquals(['a' => 1], $intersect);
    }

    public function testIntersectUkey(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $intersect = $collection->intersectUkey(fn($a, $b) => $a <=> $b, ['a' => 3]);
        $this->assertEquals(['a' => 1], $intersect);
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
        $this->assertEquals(['a', 'b'], $collection->keys());
        $this->assertEquals(['a'], $collection->keys('1'));
        $this->assertEquals(['b'], $collection->keys(2, true));
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
        $collection->merge([3, 4]);
        $this->assertEquals([1, 2, 3, 4], $collection->items());
    }

    public function testMergeRecursive(): void
    {
        $collection = new Collection(['a' => 1, 'b' => ['x' => 2]]);
        $collection->mergeRecursive(['b' => ['y' => 3], 'c' => 4]);
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
        $collection->range(1, 3);
        $this->assertEquals([1, 2, 3], $collection->items());
    }

    public function testReduce(): void
    {
        $collection = new Collection([1, 2, 3]);
        $sum = $collection->reduce(fn($carry, $item) => $carry + $item, 0);
        $this->assertEquals(6, $sum);
    }

    public function testReplace(): void
    {
        $collection = new Collection([1, 2, 3]);
        $collection->replace([4, 5]);
        $this->assertEquals([4, 5, 3], $collection->items());
    }

    public function testReplaceRecursive(): void
    {
        $collection = new Collection(['a' => 1, 'b' => ['x' => 2]]);
        $collection->replaceRecursive(['b' => ['y' => 3], 'c' => 4]);
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
        $this->assertEquals([2, 3], $slice);
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
        $diff = $collection->udiff(fn($a, $b) => $a <=> $b, [2, 3, 4]);
        $this->assertEquals([0 => 1], $diff);
    }

    public function testUdiffAssoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $diff = $collection->udiffAssoc(fn($a, $b) => $a <=> $b, ['a' => 1, 'b' => 3]);
        $this->assertEquals(['b' => 2], $diff);
    }

    public function testUdiffUassoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $diff = $collection->udiffUassoc(fn($a, $b) => $a <=> $b, fn($a, $b) => $a <=> $b, ['a' => 1, 'b' => 3]);
        $this->assertEquals(['b' => 2], $diff);
    }

    public function testUintersect(): void
    {
        $collection = new Collection([1, 2, 3]);
        $intersect = $collection->uintersect(fn($a, $b) => $a <=> $b, [2, 3, 4]);
        $this->assertEquals([1 => 2, 2 => 3], $intersect);
    }

    public function testUintersertAssoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $intersect = $collection->uintersectAssoc(fn($a, $b) => $a <=> $b, ['a' => 1, 'b' => 3]);
        $this->assertEquals(['a' => 1], $intersect);
    }

    public function testUintersertUassoc(): void
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        $intersect = $collection->uintersectUassoc(
            fn($a, $b) => $a <=> $b,
            fn($a, $b) => $a <=> $b,
            ['a' => 1, 'b' => 3]
        );
        $this->assertEquals(['a' => 1], $intersect);
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
        $this->assertEquals([1, 2], $collection->values());
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