<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroup\Plugin\Model;

use GhostUnicorns\CmsBlockCustomerGroup\Model\ResourceModel\GetCustomerGroupsByBlockId;
use Magento\Cms\Model\Block;
use Magento\Cms\Model\BlockRepository;

class BlockRepositoryPlugin
{
    /**
     * @var GetCustomerGroupsByBlockId
     */
    private $getCustomerGroupsByBlockId;

    /**
     * @param GetCustomerGroupsByBlockId $getCustomerGroupsByBlockId
     */
    public function __construct(
        GetCustomerGroupsByBlockId $getCustomerGroupsByBlockId
    ) {
        $this->getCustomerGroupsByBlockId = $getCustomerGroupsByBlockId;
    }

    /**
     * @param BlockRepository $subject
     * @param Block $result
     * @return Block
     */
    public function afterGetById(BlockRepository $subject, Block $result)
    {
        $blockId = (int)$result->getData('block_id');

        $customerGroups = $this->getCustomerGroupsByBlockId->execute($blockId);

        $result->setData('customer_group', $customerGroups);

        return $result;
    }
}
