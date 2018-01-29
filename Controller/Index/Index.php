<?php

namespace Prince\PincodeChecker\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Prince\PincodeChecker\Helper\Data
     */
    protected $helper;

     /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Prince\PincodeChecker\Helper\Data $helper
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Prince\PincodeChecker\Helper\Data $helper,
        \Magento\Framework\Controller\Result\JsonFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->helper = $helper;
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if($this->getRequest()->isAjax()){

            $pincode = $this->getRequest()->getParam('p', false);
            $id = $this->getRequest()->getParam('id', false);
            $pincodeStatus = $this->helper->getPincodeStatus($pincode);
            $productStatus = $this->helper->getProductPincodeStatus($id, $pincode);

            if($productStatus){
                $message = $this->helper->getMessage(false, $pincode);
            }else{
                $message = $this->helper->getMessage($pincodeStatus, $pincode);
            }
    
            $resultJson = $this->resultPageFactory->create();
            
            return $resultJson->setData($message);
        }

        return false;
    }
}