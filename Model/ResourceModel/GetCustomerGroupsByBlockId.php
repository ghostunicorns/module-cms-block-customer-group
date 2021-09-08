<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroup\Model\ResourceModel;

use GhostUnicorns\CmsBlockCustomerGroup\Model\Api\Data;
use Magento\Framework\App\ResourceConnection;

class GetCustomerGroupsByBlockId
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
     * @return array
     */
    public function execute(int $blockId): array
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTablePrefix() .
            $this->resourceConnection->getTableName(Data::TABLE_NAME);

        $query = $connection->select()
            ->from($tableName, [Data::CUSTOMER_GROUP_ID])
            ->where(Data::BLOCK_ID . ' = ?', $blockId);

        return $connection->fetchCol($query);
    }
}
