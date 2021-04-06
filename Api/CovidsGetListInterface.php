<?php


namespace Ghratzoo\Covid\Api;

use Ghratzoo\Covid\Api\Data\CovidInterface;

/**
 * Interface CovidsGetListInterface
 * @package Ghratzoo\Covid\Api
 * @api
 */
interface CovidsGetListInterface
{
    /**
     * @return CovidInterface[]
     */
    public function getList();
}
