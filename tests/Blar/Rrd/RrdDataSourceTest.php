<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Rrd;

use PHPUnit_Framework_TestCase as TestCase;

class RrdDataSourceTest extends TestCase {

    public function testDataSourceString() {
        $dataSource = new RrdDataSource();
        $dataSource->setName('upstream');
        $dataSource->setType(RrdDataSource::TYPE_COUNTER);
        $dataSource->setHeartbeat(900);
        $dataSource->setRange(new Range(0, 1024 * 1024 * 1024 / 8));
        $this->assertSame('upstream:COUNTER:900:0:134217728', (string) $dataSource);
    }

    public function testDataSourceStringWithoutHeartbeat() {
        $dataSource = new RrdDataSource();
        $dataSource->setName('upstream');
        $dataSource->setType(RrdDataSource::TYPE_COUNTER);
        $dataSource->setRange(new Range(0, 1024 * 1024 * 1024 / 8));
        $this->assertSame('upstream:COUNTER:300:0:134217728', (string) $dataSource);
    }

    public function testDataSourceStringWithoutRange() {
        $dataSource = new RrdDataSource();
        $dataSource->setName('upstream');
        $dataSource->setType(RrdDataSource::TYPE_COUNTER);
        $this->assertSame('upstream:COUNTER:300:U:U', (string) $dataSource);
    }

}
