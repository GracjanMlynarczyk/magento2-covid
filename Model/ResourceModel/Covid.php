<?php

namespace Ghratzoo\Covid\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Covid
 * @package Ghratzoo\Covid\Model\ResourceModel
 */
class Covid extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('ghratzoo_covid', 'covid_id');
    }

}
