<?php


namespace Prince\PincodeChecker\Model;

use Prince\PincodeChecker\Api\PincodecheckerRepositoryInterface;
use Prince\PincodeChecker\Api\Data\PincodecheckerSearchResultsInterfaceFactory;
use Prince\PincodeChecker\Api\Data\PincodecheckerInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Prince\PincodeChecker\Model\ResourceModel\Pincodechecker as ResourcePincodechecker;
use Prince\PincodeChecker\Model\ResourceModel\Pincodechecker\CollectionFactory as PincodecheckerCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class PincodecheckerRepository implements pincodecheckerRepositoryInterface
{

    protected $resource;

    protected $pincodecheckerFactory;

    protected $pincodecheckerCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataPincodecheckerFactory;

    private $storeManager;


    /**
     * @param ResourcePincodechecker $resource
     * @param PincodecheckerFactory $pincodecheckerFactory
     * @param PincodecheckerInterfaceFactory $dataPincodecheckerFactory
     * @param PincodecheckerCollectionFactory $pincodecheckerCollectionFactory
     * @param PincodecheckerSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourcePincodechecker $resource,
        PincodecheckerFactory $pincodecheckerFactory,
        PincodecheckerInterfaceFactory $dataPincodecheckerFactory,
        PincodecheckerCollectionFactory $pincodecheckerCollectionFactory,
        PincodecheckerSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->pincodecheckerFactory = $pincodecheckerFactory;
        $this->pincodecheckerCollectionFactory = $pincodecheckerCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataPincodecheckerFactory = $dataPincodecheckerFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Prince\PincodeChecker\Api\Data\PincodecheckerInterface $pincodechecker
    ) {
        /* if (empty($pincodechecker->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $pincodechecker->setStoreId($storeId);
        } */
        try {
            $this->resource->save($pincodechecker);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the pincodechecker: %1',
                $exception->getMessage()
            ));
        }
        return $pincodechecker;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($pincodecheckerId)
    {
        $pincodechecker = $this->pincodecheckerFactory->create();
        $pincodechecker->load($pincodecheckerId);
        if (!$pincodechecker->getId()) {
            throw new NoSuchEntityException(__('pincodechecker with id "%1" does not exist.', $pincodecheckerId));
        }
        return $pincodechecker;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $collection = $this->pincodecheckerCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $items = [];
        
        foreach ($collection as $pincodecheckerModel) {
            $pincodecheckerData = $this->dataPincodecheckerFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $pincodecheckerData,
                $pincodecheckerModel->getData(),
                'Prince\PincodeChecker\Api\Data\PincodecheckerInterface'
            );
            $items[] = $this->dataObjectProcessor->buildOutputDataArray(
                $pincodecheckerData,
                'Prince\PincodeChecker\Api\Data\PincodecheckerInterface'
            );
        }
        $searchResults->setItems($items);
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Prince\PincodeChecker\Api\Data\PincodecheckerInterface $pincodechecker
    ) {
        try {
            $this->resource->delete($pincodechecker);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the pincodechecker: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($pincodecheckerId)
    {
        return $this->delete($this->getById($pincodecheckerId));
    }
}
