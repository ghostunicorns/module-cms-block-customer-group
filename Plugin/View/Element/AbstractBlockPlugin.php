<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroup\Plugin\View\Element;

use Exception;
use GhostUnicorns\CmsBlockCustomerGroup\Model\AddCacheIdentity;
use GhostUnicorns\CmsBlockCustomerGroup\Model\IsBlockAllowed;
use GhostUnicorns\CmsBlockCustomerGroup\Model\ResourceModel\GetBlockIdByBlockIdentifierInterface;
use Magento\Cms\Block\Block\Interceptor;
use Magento\Cms\Block\Widget\Block;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Store\Model\StoreManagerInterface;

class AbstractBlockPlugin
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var GetBlockIdByBlockIdentifierInterface
     */
    private $getBlockIdByBlockIdentifier;

    /**
     * @var IsBlockAllowed
     */
    private $isBlockAllowed;

    /**
     * @var AddCacheIdentity
     */
    private $addCacheIdentity;

    /**
     * @param StoreManagerInterface $storeManager
     * @param GetBlockIdByBlockIdentifierInterface $getBlockIdByBlockIdentifier
     * @param IsBlockAllowed $isBlockAllowed
     * @param AddCacheIdentity $addCacheIdentity
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        GetBlockIdByBlockIdentifierInterface $getBlockIdByBlockIdentifier,
        IsBlockAllowed $isBlockAllowed,
        AddCacheIdentity $addCacheIdentity
    ) {
        $this->storeManager = $storeManager;
        $this->getBlockIdByBlockIdentifier = $getBlockIdByBlockIdentifier;
        $this->isBlockAllowed = $isBlockAllowed;
        $this->addCacheIdentity = $addCacheIdentity;
    }

    /**
     * @param AbstractBlock $subject
     * @param callable $proceed
     * @return string
     */
    public function aroundToHtml(AbstractBlock $subject, callable $proceed)
    {
        if ($this->isBlockToHide($subject)) {
            return '';
        }
        return $proceed();
    }

    /**
     * @param AbstractBlock $subject
     * @return false
     */
    private function isBlockToHide(AbstractBlock $subject): bool
    {
        if (!$subject->hasData('type')) {
            return false;
        }

        try {
            if ($subject->getData('type') === Interceptor::class) {
                $nameInLayout = $subject->getNameInLayout();
                $store = $this->storeManager->getStore();
                $storeId = (int)$store->getId();
                $blockId = (int)$this->getBlockIdByBlockIdentifier->execute($nameInLayout, $storeId);
            } elseif ($subject->getData('type') === Block::class) {
                if ($subject->hasData('block_id')) {
                    $blockId = (int)$subject->getBlockId();
                }
            }
            if (isset($blockId) && !$this->isBlockAllowed->execute($blockId)) {
                return true;
            }
        } catch (Exception $exception) {
            unset($exception);
        }
        return false;
    }

    /**
     * @param AbstractBlock $subject
     * @param $result
     * @return array
     * @throws LocalizedException
     */
    public function afterGetCacheKeyInfo(AbstractBlock $subject, $result): array
    {
        if ($this->isBlockToHide($subject)) {
            $result = $this->addCacheIdentity->execute($result);
        }
        return $result;
    }
}
