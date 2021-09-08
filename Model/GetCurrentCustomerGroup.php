<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroup\Model;

use Magento\Customer\Model\GroupManagement;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;

class GetCurrentCustomerGroup
{
    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @param Session $customerSession
     */
    public function __construct(
        Session $customerSession
    ) {
        $this->customerSession = $customerSession;
    }

    /**
     * @return int
     * @throws LocalizedException
     */
    public function execute(): int
    {
        return (int)$this->customerSession->getCustomerGroupId();
    }
}
