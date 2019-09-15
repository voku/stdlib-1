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
        $this->assertSame(0, strings\index("foo", "foo"));
        $this->assertSame(-1, strings\index("foo", "bar"));
        $this->assertSame(1, strings\index("foo", "o"));
    }

    public function testJoin()
    {
        $this->assertSame("hello world", strings\join(["hello", "world"], " "));
        $this->assertSame("1+1", strings\join(["1", "1"], "+"));
    }

    public function testLastIndex()
    {
        $this->assertSame(3, strings\last_index("foofoo", "foo"));
        $this->assertSame(-1, strings\last_index("foo", "bar"));
        $this->assertSame(2, strings\last_index("foo", "o"));
        $this->assertSame(6, strings\last_index("κόσμε\xc2\xa0ό", "ό"));
    }

    public function testMap()
    {
        $this->assertSame(
            "'Gjnf oevyyvt naq gur fyvgul tbcure...",
            strings\Map('str_rot13', "'Twas brillig and the slithy gopher...")
        );
    }

    public function testMapUnicode()
    {
        $this->assertSame(
            "κόσμε-öäü",
            strings\Map('mb_strtolower', "Κόσμε-ÖÄÜ")
        );
    }
    
    public function testRepeat()
    {
        $this->assertSame("foo", strings\repeat("foo", 1));
        $this->assertSame("foofoo", strings\repeat("foo", 2));
        $this->assertSame("", strings\repeat("foo", 0));

        $this->expectException(\UnexpectedValueException::class);
        strings\repeat("foo", -1);
    }

    public function testReplace()
    {
        $this->assertSame("bar", strings\replace("foo", "foo", "bar"));
        $this->assertSame("bar", strings\replace("foo", "foo", "bar", 1));
        $this->assertSame("foo", strings\replace("foo", "foo", "bar", 0));

        $this->assertSame("barbarfoo", strings\replace("foofoofoo", "foo", "bar", 2));
        $this->assertSame("barbarbar", strings\replace("foofoofoo", "foo", "bar"));
    }

    public function testSplit()
    {
        $this->assertSame(['a', 'b', 'c'], strings\split("a,b,c", ","));
        $this->assertSame(['', 'man ', 'plan ', 'canal panama'], strings\split("a man a plan a canal panama", "a "));
        $this->assertSame([' ', 'x', 'y', 'z', ' '], strings\split(" xyz ", ""));
        $this->assertSame([''], strings\split("", "Bernardo O'Higgins"));

        $this->assertSame(['a', 'b,c'], strings\split("a,b,c", ",", 2));
        $this->assertSame(['a', 'bc'], strings\split("abc", "", 2));
    }

    public function testToLower()
    {
        $this->assertSame('foo', strings\to_lower('FOO'));
        $this->assertSame('foo', strings\to_lower('foo'));
    }

    public function testToUpper()
    {
        $this->assertSame('FOO', strings\to_upper('FOO'));
        $this->assertSame('FOO', strings\to_upper('foo'));
    }

    public function testTrim()
    {
        $this->assertSame('Hello, Gophers', strings\trim("¡¡¡Hello, Gophers!!!", "!¡"));
        $this->assertSame("xyz", strings\trim(" xyz "));

        $this->assertSame('κöäüσμε', strings\trim('κöäüσμε' . \html_entity_decode('&nbsp;', null, 'UTF-8')));
    }

    public function testTrimLeft()
    {
        $this->assertSame('Hello, Gophers!!!', strings\trim_left("¡¡¡Hello, Gophers!!!", "!¡"));
        $this->assertSame("xyz ", strings\trim_left(" xyz "));
    }

    public function testTrimRight()
    {
        $this->assertSame('¡¡¡Hello, Gophers', strings\trim_right("¡¡¡Hello, Gophers!!!", "!¡"));
        $this->assertSame(" xyz", strings\trim_right(" xyz "));
    }
}
