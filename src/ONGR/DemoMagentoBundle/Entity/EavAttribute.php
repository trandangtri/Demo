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
use ONGR\MagentoConnectorBundle\Entity\EavAttribute as ParentEavAttribute;


/**
 * Product integer attributes entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="eav_attribute")
 */
class EavAttribute extends ParentEavAttribute
{
}
