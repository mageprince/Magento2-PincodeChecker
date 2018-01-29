<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Prince\PincodeChecker\Model\Import\Pincode;

interface RowValidatorInterface extends \Magento\Framework\Validator\ValidatorInterface
{
       const ERROR_INVALID_PINCODE= 'InvalidValuePINCODE';
       const ERROR_PINCODE_IS_EMPTY = 'EmptyPINCODE';
    /**
     * Initialize validator
     *
     * @return $this
     */
    public function init($context);
}
