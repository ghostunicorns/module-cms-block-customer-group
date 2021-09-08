<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroup\Model\ResourceModel;

use Magento\Cms\Model\GetBlockByIdentifier;

class GetBlockIdByBlockIdentifier implements GetBlockIdByBlockIdentifierInterface
{
    /**
     * @var GetBlockByIdentifier
     */
    private $getBlockByIdentifier;

    /**
     * @param GetBlockByIdentifier $getBlockByIdentifier
     */
    public function __construct(
        GetBlockByIdentifier $getBlockByIdentifier
    ) {
        $this->getBlockByIdentifier = $getBlockByIdentifier;
    }

    public function execute(string $blockIdentifier, int $storeId = null): int
    {
        $block = $this->getBlockByIdentifier->execute($blockIdentifier, $storeId);
        return (int)$block->getId();
    }
}
