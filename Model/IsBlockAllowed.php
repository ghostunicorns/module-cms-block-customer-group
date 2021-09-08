<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroup\Model;

use GhostUnicorns\CmsBlockCustomerGroup\Model\ResourceModel\GetCustomerGroupsByBlockId;
use Magento\Framework\Exception\LocalizedException;

class IsBlockAllowed
{
    /**
     * @var GetCustomerGroupsByBlockId
     */
    private $getCustomerGroupsByBlockId;

    /**
     * @var GetCurrentCustomerGroup
     */
    private $getCurrentCustomerGroup;

    /**
     * @param GetCurrentCustomerGroup $getCurrentCustomerGroup
     * @param GetCustomerGroupsByBlockId $getCustomerGroupsByBlockId
     */
    public function __construct(
        GetCurrentCustomerGroup $getCurrentCustomerGroup,
        GetCustomerGroupsByBlockId $getCustomerGroupsByBlockId
    ) {
        $this->getCustomerGroupsByBlockId = $getCustomerGroupsByBlockId;
        $this->getCurrentCustomerGroup = $getCurrentCustomerGroup;
    }

    /**
     * @param int $blockId
     * @return bool
     * @throws LocalizedException
     */
    public function execute(int $blockId): bool
    {
        $currentCustomerGroup = $this->getCurrentCustomerGroup->execute();

        $allowedCustomerGroups = $this->getCustomerGroupsByBlockId->execute($blockId);

        return empty($allowedCustomerGroups) || in_array($currentCustomerGroup, $allowedCustomerGroups);
    }
}
