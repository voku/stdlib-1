<?php

namespace php;

use php\strings;
use PHPUnit\Framework\TestCase;

class StringsTest extends TestCase
{
    public function dataCompare()
    {
        return [
            [0, "foo", "foo"],
            [-1, "bar", "foo"],
            [1, "foo", "bar"],
        ];
    }

    /**
     * @dataProvider dataCompare
     */
    public function testCompare(int $expected, string $a, string $b)
    {
        $this->assertSame($expected, strings\compare($a, $b));
    }

    public function testContains()
    {
        $this->assertTrue(strings\contains("foo", "foo"));
        $this->assertTrue(strings\contains("foobarbaz", "bar"));
        $this->assertTrue(strings\contains("foo", ""));
        $this->assertTrue(strings\contains("", ""));

        $this->assertFalse(strings\contains("foo", "bar"));
    }

    public function testHasPrefix()
    {
        $this->assertTrue(strings\has_prefix("foo", "f"));
        $this->assertTrue(strings\has_prefix("foo", "foo"));
        $this->assertTrue(strings\has_prefix("foo", ""));

        $this->assertFalse(strings\has_prefix("foo", "bar"));
        $this->assertFalse(strings\has_prefix("foo", "ofoo"));
    }

    public function testHasSuffix()
    {
        $this->assertTrue(strings\has_suffix("foo", "o"));
        $this->assertTrue(strings\has_suffix("foo", "foo"));
        $this->assertTrue(strings\has_suffix("foo", ""));

        $this->assertFalse(strings\has_suffix("foo", "bar"));
        $this->assertFalse(strings\has_suffix("foo", "oof"));
        $this->assertFalse(strings\has_suffix("foo", "foobar"));
    }

    public function testIndex()
    {
        $this->assertEquals(0, strings\index("foo", "foo"));
        $this->assertEquals(-1, strings\index("foo", "bar"));
        $this->assertEquals(1, strings\index("foo", "o"));
    }

    public function testJoin()
    {
        $this->assertEquals("hello world", strings\join(["hello", "world"], " "));
        $this->assertEquals("1+1", strings\join(["1", "1"], "+"));
    }

    public function testLastIndex()
    {
        $this->assertEquals(3, strings\last_index("foofoo", "foo"));
        $this->assertEquals(-1, strings\last_index("foo", "bar"));
        $this->assertEquals(2, strings\last_index("foo", "o"));
    }

    public function testMap()
    {
        $this->assertEquals(
            "'Gjnf oevyyvt naq gur fyvgul tbcure...",
            strings\Map('str_rot13', "'Twas brillig and the slithy gopher...")
        );
    }
}
