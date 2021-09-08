<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroup\Model\ResourceModel;

use GhostUnicorns\CmsBlockCustomerGroup\Model\Api\Data;
use Magento\Framework\App\ResourceConnection;

class DeleteByBlockId
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
     */
    public function execute(int $blockId)
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTablePrefix() .
            $this->resourceConnection->getTableName(Data::TABLE_NAME);

        $where = $connection->quoteInto(Data::BLOCK_ID . ' = ?', $blockId);

        $connection->delete($tableName, $where);
    }
}
