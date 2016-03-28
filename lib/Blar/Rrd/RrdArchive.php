<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Rrd;

/**
 * Class RrdArchive
 *
 * @package Blar\Rrd
 */
class RrdArchive {

    const CONSOLIDATION_AVERAGE = 'AVERAGE';

    const CONSOLIDATION_MIN = 'MIN';

    const CONSOLIDATION_MAX = 'MAX';

    const CONSOLIDATION_LAST = 'LAST';

    const CONSOLIDATION_DEFAULT = self::CONSOLIDATION_AVERAGE;

    private $consolidation = self::CONSOLIDATION_DEFAULT;

    /**
     * @var int
     */
    private $steps;

    /**
     * @var int
     */
    private $rows;

    /**
     * @return string
     */
    public function __toString(): string {
        return vsprintf('%s:%.1F:%u:%u', [
            $this->getConsolidation(),
            0.5,
            $this->getSteps(),
            $this->getRows()
        ]);
    }

    /**
     * @return string
     */
    public function getConsolidation(): string {
        return $this->consolidation;
    }

    /**
     * @param string $consolidation
     */
    public function setConsolidation(string $consolidation) {
        $this->consolidation = $consolidation;
    }

    /**
     * @return int
     */
    public function getSteps(): int {
        return $this->steps;
    }

    /**
     * @param int $steps
     */
    public function setSteps(int $steps) {
        $this->steps = $steps;
    }

    /**
     * @return int
     */
    public function getRows(): int {
        return $this->rows;
    }

    /**
     * @param int $rows
     */
    public function setRows(int $rows) {
        $this->rows = $rows;
    }

}
