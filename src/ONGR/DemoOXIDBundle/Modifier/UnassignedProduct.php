<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\DemoOXIDBundle\Modifier;

use Doctrine\ORM\PersistentCollection;
use ONGR\ConnectionsBundle\EventListener\AbstractImportModifyEventListener;
use ONGR\ConnectionsBundle\Pipeline\Item\AbstractImportItem;
use ONGR\ConnectionsBundle\Pipeline\ItemSkipException;
use ONGR\OXIDConnectorBundle\Entity\Article;

/**
 * UnassignedProduct class.
 */
class UnassignedProduct extends AbstractImportModifyEventListener
{
    /**
     * {@inheritdoc}
     */
    protected function modify(AbstractImportItem $eventItem)
    {
        /** @var Article $article */
        $article = $eventItem->getEntity();
        /** @var PersistentCollection $categories */
        $categories = $article->getCategories();
        if (!count($categories)) {
            throw new ItemSkipException('Product has no categories assigned.');
        }
    }
}
