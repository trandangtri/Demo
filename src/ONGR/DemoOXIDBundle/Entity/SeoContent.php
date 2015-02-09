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
use ONGR\DemoOXIDBundle\Entity\Seo as Base;

/**
 * Class SeoCategory for mapping category seo records.
 *
 * @ORM\Entity(readOnly=true)
 */
class SeoContent extends Base
{
    /**
     * @var \ONGR\DemoOXIDBundle\Entity\Content
     *
     * @ORM\ManyToOne(targetEntity="ONGR\DemoOXIDBundle\Entity\Content", inversedBy="seoUrls")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="OXOBJECTID", referencedColumnName="OXID")
     * })
     */
    protected $content;

    /**
     * @param \ONGR\DemoOXIDBundle\Entity\Content $content
     *
     * @return Seo
     */
    public function setCategory(\ONGR\DemoOXIDBundle\Entity\Content $content = null)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return \ONGR\DemoOXIDBundle\Entity\Content
     */
    public function getContent()
    {
        return $this->content;
    }
}
