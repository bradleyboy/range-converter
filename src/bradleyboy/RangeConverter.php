<?php

namespace Bradleyboy;

class RangeConverter
{
    private $output = array();
    private $range = array();
    private $separator = ',';
    private $rangeSeparator = '..';

    public function setSeparator($separator)
    {
        $this->separator = $separator;

        return $this;
    }

    public function setRangeSeparator($separator)
    {
        $this->rangeSeparator = $separator;

        return $this;
    }

    /**
     * Converts adjacent integers in a {$this->separator} separated string
     * to a range.
     *
     * Example: 1,2,3,4,6,8,9,10,11
     * Output: 1..4,6,8,9..11
     *
     * @param $string
     * @return string
     */
    public function reduceRanges($string)
    {
        $numbers = explode($this->separator, $string);
        asort($numbers);

        foreach ($numbers as $number) {
            $this->isNextInRange($number);
        }

        $this->clearRange();

        return implode($this->separator, $this->output);
    }

    /**
     * Converts ranges back to a {$this->separator} separated string.
     *
     * Example: 1..4,6,8,9..11
     * Output: 1,2,3,4,6,8,9,10,11
     *
     * @param $string
     * @return string
     */
    public function expandRanges($string)
    {
        $ranges = explode($this->separator, $string);

        $output = array_map(function ($item) {
            if (is_numeric($item)) {
                return $item;
            }

            list($start, $end) = explode($this->rangeSeparator, $item);

            return implode($this->separator, range($start, $end));
        }, $ranges);

        natcasesort($output);

        return implode($this->separator, $output);
    }

    private function isNextInRange($number)
    {
        if (empty($this->range) || $number - $this->range[count($this->range) - 1] === 1) {
            $this->range[] = $number;

            return;
        }

        $this->clearRange();

        $this->range[] = $number;
    }

    private function clearRange()
    {
        if (!empty($this->range)) {
            $this->output[] = $this->addRangeToOutput();
            $this->range    = array();
        }
    }

    private function addRangeToOutput()
    {
        if (count($this->range) === 1) {
            return array_pop($this->range);
        }

        if (count($this->range) === 2) {
            return implode($this->separator, $this->range);
        }

        $first = array_shift($this->range);
        $last  = array_pop($this->range);

        return "{$first}{$this->rangeSeparator}{$last}";
    }
}
