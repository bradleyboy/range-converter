<?php

namespace Bradleyboy\Util;

use PHPUnit_Framework_TestCase;

class RangeConverterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var RangeConverter
     */
    private $converter;

    public function setup()
    {
        $this->converter = new RangeConverter();
    }

    public function test_it_instantiates()
    {
        $this->assertInstanceOf('Bradleyboy\Util\RangeConverter', $this->converter);
    }

    public function test_it_converts_an_array_to_a_range()
    {
        $this->assertEquals('1..5', $this->converter->reduce(
            array(1, 2, 3, 4, 5)
        ));
    }

    public function test_it_converts_a_array_to_a_range_mixed()
    {
        $this->assertEquals('1..3,5', $this->converter->reduce(
            array(1, 2, 3, 5)
        ));
    }

    public function test_it_works_with_random_order()
    {
        $this->assertEquals('1..3,5', $this->converter->reduce(
            array(1, 3, 2, 5)
        ));
    }

    public function test_it_works_with_multiple_ranges()
    {
        $this->assertEquals('1..3,5,8..11', $this->converter->reduce(
            array(1, 2, 3, 5, 8, 9, 10, 11)
        ));
    }

    public function test_it_ignores_short_ranges()
    {
        $this->assertEquals('1,2,5', $this->converter->reduce(
            array(1, 2, 5)
        ));
    }

    public function test_it_ignores_multiple_short_ranges()
    {
        $this->assertEquals('1,2,5,6,9..11', $this->converter->reduce(
            array(1, 2, 5, 6, 9, 10, 11)
        ));
    }

    public function test_it_respects_custom_seperators()
    {
        $converter = new RangeConverter();
        $result = $converter->setSeparator('|')
            ->setRangeSeparator(',')
            ->reduce(
                array(1, 2, 5, 6, 9, 10, 11)
            );

        $this->assertEquals('1|2|5|6|9,11', $result);
    }

    public function test_range_hamburger()
    {
        $this->assertEquals('1,5..7,10', $this->converter->reduce(
            array(1, 5, 6, 7, 10)
        ));
    }

    public function test_expand()
    {
        $this->assertEquals(array(1, 5, 6, 7, 10), $this->converter->expand('1,5..7,10'));
    }
}
