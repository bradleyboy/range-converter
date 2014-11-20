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
     * Converts adjacent integers in an array
     * to range notation (firstNumber{rangeSeparator}lastNumber).
     *
     * Example: [1,2,3,4,6,8,9,10,11]
     * Output: 1..4,6,8,9..11
     *
     * @param array $numbers
     * @return string
     */
    public function reduceRanges($numbers)
    {
        asort($numbers);

        foreach ($numbers as $number) {
            $this->isNextInRange($number);
        }

        $this->clearRange();

        return implode($this->separator, $this->output);
    }

    /**
     * Converts string containing range notation back to array.
     *
     * Example: 1..4,6,8,9..11
     * Output: [1,2,3,4,6,8,9,10,11]
     *
     * @param string $string
     * @return array
     */
    public function expandRanges($string)
    {
        $ranges = explode($this->separator, $string);
        $output = array();

        foreach ($ranges as $range) {
            if (is_numeric($range)) {
                $output[] = $range;
                continue;
            }

            list($start, $end) = explode($this->rangeSeparator, $range);

            $output = array_merge(
                $output, range($start, $end)
            );
        }

        natcasesort($output);

        return $output;
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
