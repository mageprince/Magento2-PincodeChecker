<?php
namespace Prince\PincodeChecker\Model\ResourceModel\Pincodechecker;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected $_idFieldName = 'pincode_id';

    protected function _construct()
    {
        $this->_init(
            'Prince\PincodeChecker\Model\Pincodechecker',
            'Prince\PincodeChecker\Model\ResourceModel\Pincodechecker'
        );
    }
}
