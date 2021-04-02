<?php


namespace Ghratzoo\Covid\Service;


use Ghratzoo\Covid\Api\CovidRepositoryInterface;
use Ghratzoo\Covid\Api\Data\CovidInterface;
use Ghratzoo\Covid\Api\Data\CovidSearchResultInterface;
use Ghratzoo\Covid\Api\Data\CovidSearchResultInterfaceFactory;
use Ghratzoo\Covid\Model\Covid;
use Ghratzoo\Covid\Model\CovidFactory;
use Ghratzoo\Covid\Model\ResourceModel\Covid as CovidResource;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class CovidRepository implements CovidRepositoryInterface
{

    /**
     * @var CovidResource
     */
    private CovidResource $covid;

    /**
     * @var CovidFactory
     */
    private CovidFactory $covidFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @var CovidSearchResultInterfaceFactory
     */
    private CovidSearchResultInterfaceFactory $searchResultsFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    private FilterBuilder $filterBuilder;

    /**
     * CovidRepository constructor.
     * @param CovidResource $covid
     * @param CovidFactory $covidFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param CovidSearchResultInterfaceFactory $searchResultsFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     */
    public function __construct(
        CovidResource $covid,
        CovidFactory $covidFactory,
        CollectionProcessorInterface $collectionProcessor,
        CovidSearchResultInterfaceFactory $searchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder
    ) {
        $this->covid = $covid;
        $this->covidFactory = $covidFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
    }


    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return CovidSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CovidSearchResultInterface
    {
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);

        $this->collectionProcessor->process($searchCriteria, $searchResult);

        return $searchResult;
    }

    /**
     * @param int $covidId
     * @return CovidInterface
     */
    public function get(int $covidId): CovidInterface
    {
        $object = $this->covidFactory->create();
        $this->covid->load($object, $covidId);
        return $object;
    }

    /**
     * @return CovidInterface|null
     */
    public function getTodayCovid(): ?CovidInterface
    {
        $dateTime = new \DateTime('now');
        $dateTime->setTime(0,0, 0, 0);

        $filter = $this->filterBuilder
            ->setField(Covid::DATE)
            ->setConditionType("eq")
            ->setValue($dateTime->format('Y-m-d H:i:s'))->create();

        $searchCriteria = $this->searchCriteriaBuilder->addFilter($filter)->create();

        $items = $this->getList($searchCriteria)->getItems();
        foreach ($items as $item) {
            return $item;
        }
        return null;
    }
}
