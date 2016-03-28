<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Rrd;

use DateInterval;
use DateTimeImmutable;
use PHPUnit_Framework_TestCase as TestCase;

class RrdTest extends TestCase {

    public function testCreateAndUpdate() {
        $rrdFile = __DIR__ . "/speed.rrd";

        $rrd = new Rrd($rrdFile);
        $timestamp = new DateTimeImmutable('2016-01-01 13:37:42');

        if(file_exists($rrd->getFileName())) {
            unlink($rrd->getFileName());
        }

        if(!file_exists($rrd->getFileName())) {
            $creator = new RRDCreator();
            $creator->setFileName($rrd->getFileName());
            $creator->setStart($timestamp);
            $creator->setStep(60);

            $dataSource = new RrdDataSource();
            $dataSource->setName('downstream');
            $dataSource->setType(RrdDataSource::TYPE_COUNTER);
            $creator->addDataSource($dataSource);

            $dataSource = new RrdDataSource();
            $dataSource->setName('upstream');
            $dataSource->setType(RrdDataSource::TYPE_COUNTER);
            $creator->addDataSource($dataSource);

            $archive = new RrdArchive();
            $archive->setConsolidation(RrdArchive::CONSOLIDATION_AVERAGE);
            $archive->setSteps(60);
            $archive->setRows(60 * 24);
            $creator->addArchive($archive);

            $archive = new RrdArchive();
            $archive->setConsolidation(RrdArchive::CONSOLIDATION_AVERAGE);
            $archive->setSteps(60 * 60);
            $archive->setRows(72);
            $creator->addArchive($archive);

            $creator->save();
        }

        $rrd->setDateTime($timestamp->add(new DateInterval('PT1M')));
        $rrd->update([
            'downstream' => 1024,
            'upstream' => 768
        ]);

        $rrd->setDateTime($timestamp->add(new DateInterval('PT2M')));
        $rrd->update([
            'downstream' => 1024,
            'upstream' => 768
        ]);

        $this->assertSame('2016-01-01 13:39:42', $rrd->getDateTime()->format('Y-m-d H:i:s'));
        $this->assertSame('2016-01-01 13:39:42', $rrd->getLastUpdate()['timestamp']->format('Y-m-d H:i:s'));
    }

}
