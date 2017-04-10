<?php


namespace Prince\PincodeChecker\Model;

use Prince\PincodeChecker\Api\Data\PincodecheckerInterface;

class Pincodechecker extends \Magento\Framework\Model\AbstractModel implements PincodecheckerInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Prince\PincodeChecker\Model\ResourceModel\Pincodechecker');
    }

    /**
     * Get PINCODE_ID
     * @return string
     */
    public function getPincodecheckerId()
    {
        return $this->getData(self::PINCODE_ID);
    }

    /**
     * Set PINCODE_ID
     * @param string $pincodecheckerId
     * @return Prince\PincodeChecker\Api\Data\PincodecheckerInterface
     */
    public function setPincodecheckerId($pincodecheckerId)
    {
        return $this->setData(self::PINCODE_ID, $pincodecheckerId);
    }

    /**
     * Get pincode
     * @return string
     */
    public function getPincode()
    {
        return $this->getData(self::PINCODE);
    }

    /**
     * Set pincode
     * @param string $pincode
     * @return Prince\PincodeChecker\Api\Data\PincodecheckerInterface
     */
    public function setPincode($pincode)
    {
        return $this->setData(self::PINCODE, $pincode);
    }
}
