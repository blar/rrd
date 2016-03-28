<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Rrd;

/**
 * Class Range
 *
 * @package Blar\Rrd
 */
class Range {

    /**
     * @var mixed
     */
    private $min;

    /**
     * @var mixed
     */
    private $max;

    /**
     * @param mixed $min
     * @param mixed $max
     */
    public function __construct($min = NULL, $max = NULL) {
        $this->setMin($min);
        $this->setMax($max);
    }

    /**
     * @return bool
     */
    public function hasMin(): bool {
        return !is_null($this->min);
    }

    /**
     * @return mixed
     */
    public function getMin() {
        return $this->min;
    }

    /**
     * @param mixed $min
     * @return $this
     */
    public function setMin($min) {
        $this->min = $min;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasMax(): bool {
        return !is_null($this->max);
    }

    /**
     * @return mixed
     */
    public function getMax() {
        return $this->max;
    }

    /**
     * @param mixed $max
     * @return $this
     */
    public function setMax($max) {
        $this->max = $max;
        return $this;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate($value): bool {
        if(!$this->hasMin() and $this->getMin() >= $value) {
            return FALSE;
        }
        if(!$this->hasMax() and $this->getMax() <= $value) {
            return FALSE;
        }
        return TRUE;
    }

}
