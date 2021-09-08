<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroup\Model\ResourceModel;

use Magento\Framework\Exception\NoSuchEntityException;

interface GetBlockIdByBlockIdentifierInterface
{
    /**
     * @param string $blockIdentifier
     * @param int|null $storeId
     * @return int
     * @throws NoSuchEntityException
     */
    public function execute(string $blockIdentifier, int $storeId = null): int;
}
