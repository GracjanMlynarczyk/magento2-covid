<?php


namespace Ghratzoo\Covid\Service;


use Ghratzoo\Covid\Api\CovidRepositoryInterface;
use Ghratzoo\Covid\Api\CovidsGetListInterface;
use Ghratzoo\Covid\Api\Data\CovidInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class CovidsGetList implements CovidsGetListInterface
{

    /**
     * @var CovidRepositoryInterface
     */
    private $covidRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCiteriaBuilder;

    /**
     * CustomerTaskList constructor.
     * @param CovidRepositoryInterface $covidRepository
     * @param SearchCriteriaBuilder $searchCiteriaBuilder
     */
    public function __construct(CovidRepositoryInterface $covidRepository, SearchCriteriaBuilder $searchCiteriaBuilder)
    {
        $this->covidRepository = $covidRepository;
        $this->searchCiteriaBuilder = $searchCiteriaBuilder;
    }


    /**
     * @return CovidInterface[]
     */
    public function getList()
    {
        return $this->covidRepository->getList($this->searchCiteriaBuilder->create())->getItems();
    }
}
