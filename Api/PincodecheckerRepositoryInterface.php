<?php


namespace Prince\PincodeChecker\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface PincodecheckerRepositoryInterface
{


    /**
     * Save pincodechecker
     * @param \Prince\PincodeChecker\Api\Data\PincodecheckerInterface $pincodechecker
     * @return \Prince\PincodeChecker\Api\Data\PincodecheckerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function save(
        \Prince\PincodeChecker\Api\Data\PincodecheckerInterface $pincodechecker
    );

    /**
     * Retrieve pincodechecker
     * @param string $pincodecheckerId
     * @return \Prince\PincodeChecker\Api\Data\PincodecheckerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getById($pincodecheckerId);

    /**
     * Retrieve pincodechecker matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Prince\PincodeChecker\Api\Data\PincodecheckerSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete pincodechecker
     * @param \Prince\PincodeChecker\Api\Data\PincodecheckerInterface $pincodechecker
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function delete(
        \Prince\PincodeChecker\Api\Data\PincodecheckerInterface $pincodechecker
    );

    /**
     * Delete pincodechecker by ID
     * @param string $pincodecheckerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function deleteById($pincodecheckerId);
}
