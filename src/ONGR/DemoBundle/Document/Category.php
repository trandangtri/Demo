<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\DemoBundle\Document;

use ONGR\ContentBundle\Document\AbstractCategoryDocument;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Stores category data.
 *
 * @ES\Document(type="category")
 */
class Category extends AbstractCategoryDocument
{
    /**
     * @var string
     *
     * @ES\Property(name="slug", type="string", index="not_analyzed")
     */
    public $slug;
}
