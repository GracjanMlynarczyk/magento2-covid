<?php

namespace Ghratzoo\Covid\Api;

use Ghratzoo\Covid\Api\Data\CovidInterface;
use Ghratzoo\Covid\Api\Data\CovidSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface CovidRepositoryInterface
 * @package Ghratzoo\Covid\Api
 * @api
 */
interface CovidRepositoryInterface
{
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return CovidSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CovidSearchResultInterface;

    /**
     * @param int $covidId
     * @return CovidInterface
     */
    public function get(int $covidId): CovidInterface;

    /**
     * @return CovidInterface|null
     */
    public function getTodayCovid(): ?CovidInterface;
}
