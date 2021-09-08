<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroup\Model\ResourceModel;

use GhostUnicorns\CmsBlockCustomerGroup\Model\Api\Data;
use Magento\Framework\App\ResourceConnection;

class AddCustomerGroupByBlockId
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param int $blockId
     * @param int $customerGroup
     */
    public function execute(int $blockId, int $customerGroup)
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTablePrefix() .
            $this->resourceConnection->getTableName(Data::TABLE_NAME);

        $connection->insert(
            $tableName,
            [
                Data::BLOCK_ID => $blockId,
                Data::CUSTOMER_GROUP_ID => $customerGroup,
            ]
        );
    }
}
