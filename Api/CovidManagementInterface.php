<?php
declare(strict_types=1);

namespace Ghratzoo\Covid\Api;

use Ghratzoo\Covid\Api\Data\CovidInterface;

/**
 * Interface CovidManagementInterface
 * @package Ghratzoo\Covid\Api
 * @api
 */
interface CovidManagementInterface
{
    /**
     * @param CovidInterface $covid
     * @return int
     */
    public function save(CovidInterface $covid): int;

    /**
     * @param CovidInterface $covid
     * @return bool
     */
    public function delete(CovidInterface $covid): bool;
}
