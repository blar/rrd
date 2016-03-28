[![License](https://poser.pugx.org/blar/rrd/license)](https://packagist.org/packages/blar/rrd)
[![Latest Stable Version](https://poser.pugx.org/blar/rrd/v/stable)](https://packagist.org/packages/blar/rrd)
[![Build Status](https://travis-ci.org/blar/rrd.svg?branch=master)](https://travis-ci.org/blar/rrd)
[![Coverage Status](https://coveralls.io/repos/blar/rrd/badge.svg?branch=master)](https://coveralls.io/r/blar/rrd?branch=master)
[![Dependency Status](https://gemnasium.com/blar/rrd.svg)](https://gemnasium.com/blar/rrd)
[![Flattr](https://button.flattr.com/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=Blar&url=https%3A%2F%2Fgithub.com%2Fblar%2Frrd)

# blar/rrd

## Define a new RRD file

    $timestamp = new DateTimeImmutable('2016-01-01 13:37:42');

    $creator = new RRDCreator();
    $creator->setFileName($rrd->getFileName());
    $creator->setStart($timestamp);
    $creator->setStep(60);

## Add data source for downstream

    $dataSource = new RrdDataSource();
    $dataSource->setName('downstream');
    $dataSource->setType(RrdDataSource::TYPE_COUNTER);
    $creator->addDataSource($dataSource);

## Add data source for upstream

    $dataSource = new RrdDataSource();
    $dataSource->setName('upstream');
    $dataSource->setType(RrdDataSource::TYPE_COUNTER);
    $creator->addDataSource($dataSource);

## Add archive

    $archive = new RrdArchive();
    $archive->setConsolidation(RrdArchive::CONSOLIDATION_AVERAGE);
    $archive->setSteps(60);
    $archive->setRows(60 * 24);
    $creator->addArchive($archive);

## Save the new RRD file

    $creator->save();

## Push data

    $rrd->update([
        'downstream' => 1024,
        'upstream' => 768
    ]);

## Get last update

    $rrd->getLastUpdate();
