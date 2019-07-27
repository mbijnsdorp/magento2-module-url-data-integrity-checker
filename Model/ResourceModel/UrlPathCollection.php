<?php

declare(strict_types=1);

namespace Baldwin\UrlDataIntegrityChecker\Model\ResourceModel;

use Baldwin\UrlDataIntegrityChecker\Checker\Catalog\Product\UrlPath as UrlPathChecker;
use Baldwin\UrlDataIntegrityChecker\Storage\Cache as CacheStorage;
use Magento\Framework\Api\AttributeInterface;
use Magento\Framework\Api\AttributeValue;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection as DataCollection;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Exception\LocalizedException;

class UrlPathCollection extends DataCollection implements SearchResultInterface
{
    private $storage;

    public function __construct(
        EntityFactoryInterface $entityFactory,
        CacheStorage $storage
    ) {
        parent::__construct($entityFactory);

        $this->storage = $storage;
    }

    public function loadData($printQuery = false, $logQuery = false)
    {
        if (!$this->isLoaded()) {
            $urlPaths = $this->storage->read(UrlPathChecker::STORAGE_IDENTIFIER);
            foreach ($urlPaths as $urlPath) {
                $this->addItem($this->createDataObject($urlPath));
            }

            $this->_setIsLoaded();
        }

        return $this;
    }

    public function createDataObject(array $arguments = [])
    {
        $obj = $this->_entityFactory->create($this->_itemObjectClass, ['data' => $arguments]);

        $attributes = [];
        foreach ($arguments as $key => $value) {
            $attribute = new AttributeValue([
                AttributeInterface::ATTRIBUTE_CODE => $key,
                AttributeInterface::VALUE => $value,
            ]);

            $attributes[] = $attribute;
        }
        $obj->setCustomAttributes($attributes);

        return $obj;
    }

    public function setItems(array $items = null)
    {
        throw new LocalizedException(__('Not implemented: setItems!'));
    }

    public function getAggregations()
    {
        throw new LocalizedException(__('Not implemented: getAggregations!'));
    }

    public function setAggregations($aggregations)
    {
        throw new LocalizedException(__('Not implemented: setAggregations!'));
    }

    public function getSearchCriteria()
    {
        throw new LocalizedException(__('Not implemented: getSearchCriteria!'));
    }

    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria)
    {
        throw new LocalizedException(__('Not implemented: setSearchCriteria!'));
    }

    public function getTotalCount()
    {
        return $this->getSize();
    }

    public function setTotalCount($totalCount)
    {
        throw new LocalizedException(__('Not implemented: setTotalCount!'));
    }
}