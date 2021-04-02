<?php

namespace Ghratzoo\Covid\Api\Data;


use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface CovidSearchResultInterface
 * @package Ghratzoo\Covid\Api\Data
 * @api
 */
interface CovidSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return CovidInterface[]
     */
    public function getItems();

    /**
     * @param CovidInterface[] $items
     * @return CovidSearchResultInterface
     */
    public function setItems(array $items): CovidSearchResultInterface;
}
