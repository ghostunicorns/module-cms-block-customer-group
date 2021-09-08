<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroup\Model;

use GhostUnicorns\CmsBlockCustomerGroup\Model\ResourceModel\AddCustomerGroupByBlockId;
use GhostUnicorns\CmsBlockCustomerGroup\Model\ResourceModel\DeleteByBlockId;
use Magento\Cms\Model\BlockFactory;

class SaveCmsBlockCustomerGroup
{
    /**
     * @var ResourceModel\DeleteByBlockId
     */
    private $deleteByBlockId;

    /**
     * @var ResourceModel\AddCustomerGroupByBlockId
     */
    private $addCustomerGroupByBlockId;

    /**
     * @param ResourceModel\DeleteByBlockId $deleteByBlockId
     * @param ResourceModel\AddCustomerGroupByBlockId $addCustomerGroupByBlockId
     */
    public function __construct(
        DeleteByBlockId $deleteByBlockId,
        AddCustomerGroupByBlockId $addCustomerGroupByBlockId
    ) {
        $this->deleteByBlockId = $deleteByBlockId;
        $this->addCustomerGroupByBlockId = $addCustomerGroupByBlockId;
    }

    /**
     * @param int $blockId
     * @param array $customerGroups
     */
    public function execute(int $blockId, array $customerGroups)
    {
        $this->deleteByBlockId->execute($blockId);
        foreach ($customerGroups as $customerGroup) {
            $this->addCustomerGroupByBlockId->execute($blockId, (int)$customerGroup);
        }
    }
}
