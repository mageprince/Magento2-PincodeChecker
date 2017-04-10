<?php


namespace Prince\PincodeChecker\Model\ResourceModel;

class Pincodechecker extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('prince_pincodechecker', 'pincode_id');
    }
}
