<?php

namespace Prince\PincodeChecker\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    protected $pincodeCollection;

    protected $product;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Catalog\Model\Product $product
     * @param \Prince\PincodeChecker\Model\ResourceModel\Pincodechecker\CollectionFactory $pincodeCollection
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Model\Product $product,
        \Prince\PincodeChecker\Model\ResourceModel\Pincodechecker\CollectionFactory $pincodeCollection
    )
    {
        $this->pincodeCollection = $pincodeCollection;
        $this->product = $product;
        parent::__construct($context);
    }

    /**
     * Get collection of pincode
     */
    public function getCollection()
    {
        return $this->pincodeCollection->create();
    }

    /**
     * Get pincode status
     */
    public function getPincodeStatus($pincode)
    {
        $collection = $this->getCollection();
        $collection->addFieldToFilter('pincode', array('eq' => $pincode));
        
        if($collection->getData()){
            return true;
        }else{
            return false;
        }

    }

    /**
     * Get pincode status by product
     */
    public function getProductPincodeStatus($id, $pincode)
    {
        $product = $this->product->load($id);
        $pincodes = $product->getData('pincode');
        $pincodeArr = explode(',', $pincodes);

        if(in_array($pincode, $pincodeArr))
        {
            return true;
        }else{
            return false;
        }
            
    }

    /**
     * Get pincode status message
     */
    public function getMessage($status, $pincode)
    {
        if($status){
            $message = "<h3>Pincode \"{$pincode}\" is Available For This Product</h3>";
        }else{
            $message = "<h3 style='color:red'>Pincode \"{$pincode}\" is Not Available For This Product</h3>";
        }

        return $message;
    }
}