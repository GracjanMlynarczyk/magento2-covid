<?php


namespace Ghratzoo\Covid\Service;


use Exception;
use Ghratzoo\Covid\Api\CovidManagementInterface;
use Ghratzoo\Covid\Api\Data\CovidInterface;
use Ghratzoo\Covid\Model\ResourceModel\Covid as CovidResource;
use Magento\Framework\Exception\AlreadyExistsException;

class CovidManagement implements CovidManagementInterface
{

    /**
     * @var CovidResource
     */
    private CovidResource $resource;

    /**
     * CovidManagement constructor.
     * @param CovidResource $resource
     */
    public function __construct(CovidResource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @param CovidInterface $covid
     * @return int
     * @throws AlreadyExistsException
     */
    public function save(CovidInterface $covid): int
    {
        $this->resource->save($covid);
        return $covid->getCovidId();
    }

    /**
     * @param CovidInterface $covid
     * @return bool
     * @throws Exception
     */
    public function delete(CovidInterface $covid): bool
    {
        $this->resource->delete($covid);
        return true;
    }
}
