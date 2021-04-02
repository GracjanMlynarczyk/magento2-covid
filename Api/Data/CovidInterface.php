<?php
declare(strict_types=1);

namespace Ghratzoo\Covid\Api\Data;

use DateTime;

/**
 * Interface CovidInterface
 * @package Ghratzoo\Covid\Api\Data
 * @api
 */
interface CovidInterface
{

    /**
     * @return int
     */
    public function getCovidId(): int;

    /**
     * @return int
     */
    public function getConfirmed(): int;

    /**
     * @return int
     */
    public function getDeaths(): int;

    /**
     * @return int
     */
    public function getRecovered(): int;

    /**
     * @return string
     */
    public function getDate(): string;

    /**
     * @param int $id
     */
    public function setCovidId(int $id): void;

    /**
     * @param int $confirmed
     */
    public function setConfirmed(int $confirmed): void;

    /**
     * @param int $deaths
     */
    public function setDeaths(int $deaths): void;

    /**
     * @param int $recovered
     */
    public function setRecovered(int $recovered): void;

    /**
     * @param string $dateTime
     */
    public function setDate(string $dateTime): void;
}
