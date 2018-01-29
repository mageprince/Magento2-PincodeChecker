<?php
 
namespace Prince\PincodeChecker\Plugin;
 
use Magento\Framework\Exception\LocalizedException;
 
class PincodeChecker
{
    /**
     * @var \Magento\Quote\Model\Quote
     */
    protected $quote;
    
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Prince\PincodeChecker\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $message;
 
    /**
     * Plugin constructor.
     *
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Prince\PincodeChecker\Helper\Data $helper
     * @param \Magento\Framework\Message\ManagerInterface $message
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\Request\Http $request,
        \Prince\PincodeChecker\Helper\Data $helper,
        \Magento\Framework\Message\ManagerInterface $message     
    ) {
        $this->quote = $checkoutSession->getQuote();
        $this->request = $request;
        $this->helper = $helper;
        $this->message = $message;
    }
 
    /**
     * beforeAddProduct
     *
     * @param      $subject
     * @param      $productInfo
     * @param null $requestInfo
     *
     * @return array
     * @throws LocalizedException
     */
    public function beforeAddProduct($subject, $productInfo, $requestInfo = null)
    {        
        $enable = $this->helper->getIsEnable();
        $checkAddToCart = $this->helper->getIsCheckonAddtoCart();
        $pincode = $this->request->getParam('pincode');

        if($enable && $checkAddToCart && $pincode){
            $id = $productInfo->getId();
            $pincodeStatus = $this->helper->getPincodeStatus($pincode);
            $productStatus = $this->helper->getProductPincodeStatus($id, $pincode);

            if($productStatus){
                $this->message->addError($this->helper->getFailMessage());
                $this->helper->getRedirect();
                exit;
            }elseif(!$pincodeStatus){
                $this->message->addError($this->helper->getFailMessage());
                $this->helper->getRedirect();
                exit;
            }
        }
    }
    
}