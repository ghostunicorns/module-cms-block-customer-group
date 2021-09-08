<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroup\Model;

use Magento\Framework\Exception\LocalizedException;

class AddCacheIdentity
{
    /**
     * Customer group cache tag for CMS Block
     */
    const CACHE_TAG = 'customer_group_';

    /**
     * @var GetCurrentCustomerGroup
     */
    private $getCurrentCustomerGroup;

    /**
     * @param GetCurrentCustomerGroup $getCurrentCustomerGroup
     */
    public function __construct(
        GetCurrentCustomerGroup $getCurrentCustomerGroup
    ) {
        $this->getCurrentCustomerGroup = $getCurrentCustomerGroup;
    }

    /**
     * @param array $identities
     * @return array
     * @throws LocalizedException
     */
    public function execute(array $identities): array
    {
        $currentCustomerGroup = $this->getCurrentCustomerGroup->execute();
        $identities[] = self::CACHE_TAG . $currentCustomerGroup;
        return $identities;
    }
}
