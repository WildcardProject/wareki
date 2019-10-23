<?php
use PHPUnit\Framework\TestCase;
use programming_cat\Wareki\Converter;

class WarekiTest extends TestCase {
    protected $wareki;

    protected function setup() {
        $this->converter = new Converter;
    }

    public function test_日付を和暦に変換できる() {
        $this->assertEquals("明治元年2月3日", $this->converter->wareki("1869-02-03"));
        $this->assertEquals("大正元年7月30日", $this->converter->wareki("1912-07-30"));
        $this->assertEquals("大正15年12月24日", $this->converter->wareki("1926-12-24"));
        $this->assertEquals("昭和元年12月25日", $this->converter->wareki("1926-12-25"));
        $this->assertEquals("昭和64年1月7日", $this->converter->wareki("1989-01-07"));
        $this->assertEquals("平成元年1月8日", $this->converter->wareki("1989-01-08"));
        $this->assertEquals("平成31年4月30日", $this->converter->wareki("2019-04-30"));
        $this->assertEquals("令和元年5月1日", $this->converter->wareki("2019-05-01"));
    }

    public function test_年だけ和暦に変換できる() {
        $this->assertEquals("明治元年", $this->converter->wareki("1869"));
        $this->assertEquals("大正元年", $this->converter->wareki("1912"));
        $this->assertEquals("大正14年", $this->converter->wareki("1925"));
        $this->assertEquals("昭和元年", $this->converter->wareki("1926"));
        $this->assertEquals("昭和63年", $this->converter->wareki("1988"));
        $this->assertEquals("平成元年", $this->converter->wareki("1989"));
        $this->assertEquals("平成30年", $this->converter->wareki("2018"));
        $this->assertEquals("令和元年/平成31年", $this->converter->wareki("2019"));
    }

}
