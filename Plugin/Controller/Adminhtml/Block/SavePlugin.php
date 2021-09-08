<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CmsBlockCustomerGroup\Plugin\Controller\Adminhtml\Block;

use GhostUnicorns\CmsBlockCustomerGroup\Model\SaveCmsBlockCustomerGroup;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Controller\Adminhtml\Block\Save;
use Magento\Cms\Model\BlockFactory;
use Magento\Cms\Model\ResourceModel\Block;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Exception\LocalizedException;

class SavePlugin
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var SaveCmsBlockCustomerGroup
     */
    private $saveCmsBlockCustomerGroup;

    /**
     * @var Block
     */
    private $block;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * @var MetadataPool
     */
    private $metadataPool;

    /**
     * @param RequestInterface $request
     * @param SaveCmsBlockCustomerGroup $saveCmsBlockCustomerGroup
     * @param Block $block
     * @param BlockFactory $blockFactory
     * @param MetadataPool $metadataPool
     */
    public function __construct(
        RequestInterface $request,
        SaveCmsBlockCustomerGroup $saveCmsBlockCustomerGroup,
        Block $block,
        BlockFactory $blockFactory,
        MetadataPool $metadataPool
    )
    {
        $this->request = $request;
        $this->saveCmsBlockCustomerGroup = $saveCmsBlockCustomerGroup;
        $this->block = $block;
        $this->blockFactory = $blockFactory;
        $this->metadataPool = $metadataPool;
    }

    /**
     * @param Save $subject
     * @param $result
     * @return mixed
     */
    public function afterExecute(Save $subject, $result)
    {
        $data = $this->request->getPostValue();

        if (!$data) {
            return $result;
        }
        if (array_key_exists('id', $data)) {
            $blockId = $data['id'];
        } else {
            $block = $this->blockFactory->create();
            $blockIdentifier = $data['identifier'];
            $this->block->load($block, $blockIdentifier, 'identifier');

            $entityMetadata = $this->metadataPool->getMetadata(BlockInterface::class);
            $field = $entityMetadata->getLinkField();
            $blockId = (int)$block->getData($field);
        }

        $customerGroups = $data['customer_group'] ?: [];

        try {
            $this->saveCmsBlockCustomerGroup->execute($blockId, $customerGroups);
        } catch (LocalizedException $exception) {
            unset($exception);
        }

        return $result;
    }
}
