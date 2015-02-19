<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\DemoMagentoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductWebsite as ParentCatalogProductWebsite;

/**
 * Product integer attributes entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="catalog_product_website")
 */
class CatalogProductWebsite extends ParentCatalogProductWebsite
{
}
