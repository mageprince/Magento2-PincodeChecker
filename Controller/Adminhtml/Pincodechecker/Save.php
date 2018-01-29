<?php


namespace Prince\PincodeChecker\Controller\Adminhtml\Pincodechecker;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('pincode_id');
        
            $model = $this->_objectManager->create('Prince\PincodeChecker\Model\Pincodechecker')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This Pincode no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        
            $model->setData($data);
        
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the Pincode.'));
                $this->dataPersistor->clear('prince_pincodechecker_pincodechecker');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['pincode_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Pincode.'));
            }
        
            $this->dataPersistor->set('prince_pincodechecker_pincodechecker', $data);
            return $resultRedirect->setPath('*/*/edit', ['pincode_id' => $this->getRequest()->getParam('pincode_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
