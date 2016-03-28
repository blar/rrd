<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Rrd;

use DateTime;
use DateTimeInterface;

class Rrd {

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var DateTimeInterface
     */
    private $dateTime;

    /**
     * @param string $fileName
     */
    public function __construct(string $fileName) {
        $this->setFileName($fileName);
    }

    /**
     * @return string
     */
    public function getFileName(): string {
        return $this->fileName;
    }

    /**
     * @return bool
     */
    public function hasDateTime(): bool {
        return !is_null($this->dateTime);
    }

    /**
     * @return DateTimeInterface
     */
    public function getDateTime(): DateTimeInterface {
        if(!$this->hasDateTime()) {
            return new DateTime();
        }
        return $this->dateTime;
    }

    /**
     * @param DateTimeInterface $dateTime
     */
    public function setDateTime(DateTimeInterface $dateTime) {
        $this->dateTime = $dateTime;
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName) {
        $this->fileName = $fileName;
    }

    /**
     * @param array $data
     */
    public function update(array $data) {
        $fields = implode(':', array_keys($data));
        $values = $this->getDateTime()->getTimestamp().'@'.implode(':', $data);
        rrd_update($this->getFileName(), [
            '--template',
            $fields,
            $values
        ]);
    }

    /**
     * @return array
     */
    public function getInfo(): array {
        return rrd_info($this->getFileName());
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function fetch(array $options): array {
        return rrd_fetch($this->getFileName(), $this->convertOptions($options));
    }

    /**
     * @return array
     */
    public function getLastUpdate(): array {
        $result = rrd_lastupdate($this->getFileName());

        $info = [];
        $info['timestamp'] = new DateTime('@'.$result['last_update']);
        $info['values'] = array_combine($result['ds_navm'], $result['data']);

        return $info;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function convertOptions(array $options): array {
        $result = [];
        foreach($options as $key => $value) {
            if(!is_numeric($key)) {
                $result[] = $key;
            }
            $result[] = $value;
        }
        return $result;
    }

}
