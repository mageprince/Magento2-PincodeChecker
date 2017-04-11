<?php

namespace Prince\PincodeChecker\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    protected $pincodeCollection;

    protected $product;

    protected $resultFactory;

    /**
     * @var \Magento\Store\Model\ScopeInterface
     */
    protected $scopeConfig;

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
        \Prince\PincodeChecker\Model\ResourceModel\Pincodechecker\CollectionFactory $pincodeCollection,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->pincodeCollection = $pincodeCollection;
        $this->product = $product;
        $this->resultFactory = $resultFactory;
        $this->scopeConfig = $scopeConfig;
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
            $message = "<h3>".$this->getSuccessMessage()."</h3>";
        }else{
            $message = "<h3 style='color:red'>".$this->getFailMessage()."</h3>";
        }

        return $message;
    }

    public function getRedirect()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }

    public function getIsEnable()
    {
        return $this->scopeConfig->getValue('pincode/general/active', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getIsCheckonAddtoCart()
    {
        return $this->scopeConfig->getValue('pincode/general/checkaddtocart', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getSuccessMessage()
    {
        return $this->scopeConfig->getValue('pincode/general/successmessage', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getFailMessage()
    {
        return $this->scopeConfig->getValue('pincode/general/failmessage', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}