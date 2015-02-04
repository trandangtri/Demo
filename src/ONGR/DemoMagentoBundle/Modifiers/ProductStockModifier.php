<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\DemoMagentoBundle\Modifiers;

use ONGR\ConnectionsBundle\EventListener\AbstractImportModifyEventListener;
use ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent;
use ONGR\ConnectionsBundle\Pipeline\Item\AbstractImportItem;
use ONGR\ConnectionsBundle\Pipeline\ItemSkipper;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntity;

/**
 * Modifies entities to match ongr product mapping.
 */
class ProductStockModifier extends AbstractImportModifyEventListener
{
    /**
     * @var int
     */
    protected $storeId;

    /**
     * @param int $storeId
     */
    public function __construct($storeId)
    {
        $this->storeId = $storeId;
    }

    /**
     * {@inheritdoc}
     */
    protected function modify(AbstractImportItem $eventItem, ItemPipelineEvent $event)
    {
        /** @var CatalogProductEntity $entity */
        $entity = $eventItem->getEntity();
        $this->isItemInStock($entity, $event);
    }

    /**
     * Checks if item is in stock. If it is imports.
     *
     * @param CatalogProductEntity $entity
     * @param ItemPipelineEvent    $event
     */
    public function isItemInStock(CatalogProductEntity $entity, ItemPipelineEvent $event)
    {
        $priceArray = [];
        $prices = $entity->getPrices();
        foreach ($prices as $price) {
            if ($price->getPrice() !== null) {
                $priceArray[] = $price->getPrice();
                break;
            }
        }

        if (count($priceArray) == 0) {
            ItemSkipper::skip($event, 'Product ' . $entity->getId() . ' is out of stock, so it wont be imported.');

            return;
        }
    }
}
