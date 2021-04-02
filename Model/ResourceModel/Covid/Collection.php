<?php


namespace Ghratzoo\Covid\Model\ResourceModel\Covid;


use Ghratzoo\Covid\Api\Data\CovidSearchResultInterface;
use Ghratzoo\Covid\Model\Covid;
use Ghratzoo\Covid\Model\ResourceModel\Covid as CovidResource;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection implements CovidSearchResultInterface
{
    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteria;

    protected function _construct()
    {
        $this->_init(Covid::class, CovidResource::class);
    }

    public function getSearchCriteria()
    {
        return $this->searchCriteria;
    }

    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        $this->searchCriteria = $searchCriteria;
        return $this;
    }


    public function getTotalCount()
    {
        return $this->getSize();
    }

    public function setTotalCount($totalCount)
    {
        return $this;
    }

    public function setItems(array $items): CovidSearchResultInterface
    {
        if (!$items) {
            return $this;
        }

        foreach ($items as $item) {
            $this->addItem($item);
        }
        return $this;
    }
}
