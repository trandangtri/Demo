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
use ONGR\DemoOXIDBundle\Entity\AbstractSeo as Base;

/**
 * Class SeoCategory for mapping categories seo records.
 *
 * @ORM\Entity(readOnly=true)
 */
class SeoCategory extends Base
{
    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="ONGR\DemoOXIDBundle\Entity\Category", inversedBy="seoUrls")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="OXOBJECTID", referencedColumnName="OXID")
     * })
     */
    protected $category;

    /**
     * @param Category $category
     *
     * @return $this
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
