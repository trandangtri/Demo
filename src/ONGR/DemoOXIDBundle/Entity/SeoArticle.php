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
 * Class SeoArticle for mapping articles seo records.
 *
 * @ORM\Entity(readOnly=true)
 */
class SeoArticle extends Base
{
    /**
     * @var \ONGR\DemoOXIDBundle\Entity\Article
     *
     * @ORM\ManyToOne(targetEntity="ONGR\DemoOXIDBundle\Entity\Article", inversedBy="seoUrls")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="OXOBJECTID", referencedColumnName="OXID")
     * })
     */
    protected $article;

    /**
     * @param \ONGR\DemoOXIDBundle\Entity\Article $article
     *
     * @return Oxseo
     */
    public function setArticle(\ONGR\DemoOXIDBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * @return \ONGR\DemoOXIDBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
