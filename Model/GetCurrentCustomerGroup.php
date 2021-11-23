<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroup\Model;

use Magento\Customer\Model\GroupManagement;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Exception\LocalizedException;

class GetCurrentCustomerGroup
{
    /**
     * @var SessionFactory
     */
    private $customerSessionFactory;

    /**
     * @param SessionFactory $customerSessionFactory
     */
    public function __construct(
        SessionFactory $customerSessionFactory
    ) {
        $this->customerSessionFactory = $customerSessionFactory;
    }

    /**
     * @return int
     * @throws LocalizedException
     */
    public function execute(): int
    {
        $customerGroupId = $this->customerSessionFactory->create();
        return (int)$customerGroupId->getCustomerGroupId();
    }
}
