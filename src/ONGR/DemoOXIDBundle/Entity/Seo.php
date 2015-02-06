<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\DemoOXIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ONGR\OXIDConnectorBundle\Entity\Seo as Base;

/**
 * A class to test ONGR\OXIDConnectorBundle\Entity\Seo abstract class.
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="OXTYPE", type="string")
 * @ORM\DiscriminatorMap({
 *           "oxarticle" = "ONGR\DemoOXIDBundle\Entity\SeoArticle",
 *           "oxcategory" = "ONGR\DemoOXIDBundle\Entity\SeoCategory",
 *           "oxcontent" = "ONGR\DemoOXIDBundle\Entity\SeoContent"
 * })
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="oxseo")
 */
abstract class Seo extends Base
{
}
