<?php

namespace Ghratzoo\Covid\Model;

use DateTime;
use Ghratzoo\Covid\Api\Data\CovidInterface;
use Ghratzoo\Covid\Model\ResourceModel\Covid as CovidResource;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Covid
 * @package Ghratzoo\Covid\Model
 */
class Covid extends AbstractModel implements CovidInterface
{
    const COVID_ID = 'covid_id';
    const CONFIRMED = 'confirmed';
    const DEATHS = 'deaths';
    const RECOVERED = 'recovered';
    const DATE = 'date';


    protected function _construct()
    {
        $this->_init(CovidResource::class);
    }

    /**
     * @return int
     */
    public function getCovidId(): int
    {
        return (int) $this->getData(self::COVID_ID);
    }

    /**
     * @return int
     */
    public function getConfirmed(): int
    {
        return (int) $this->getData(self::CONFIRMED);
    }

    /**
     * @return int
     */
    public function getDeaths(): int
    {
        return (int) $this->getData(self::DEATHS);
    }

    /**
     * @return int
     */
    public function getRecovered(): int
    {
        return (int) $this->getData(self::RECOVERED);
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->getData(self::DATE);
    }

    /**
     * @param int $id
     */
    public function setCovidId(int $id): void
    {
        $this->setData(self::COVID_ID, $id);
    }

    /**
     * @param int $confirmed
     */
    public function setConfirmed(int $confirmed): void
    {
        $this->setData(self::CONFIRMED, $confirmed);
    }

    /**
     * @param int $deaths
     */
    public function setDeaths(int $deaths): void
    {
        $this->setData(self::DEATHS, $deaths);
    }

    /**
     * @param int $recovered
     */
    public function setRecovered(int $recovered): void
    {
        $this->setData(self::RECOVERED, $recovered);
    }

    /**
     * @param string $dateTime
     */
    public function setDate(string $dateTime): void
    {
        $this->setData(self::DATE, $dateTime);
    }
}
