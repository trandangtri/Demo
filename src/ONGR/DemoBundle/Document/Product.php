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

use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Product document.
 *
 * @ES\Document(type="product")
 */
class Product
{
    /**
     * @var string
     *
     * @ES\Property(name="sku", type="string", options={"index"="not_analyzed"})
     */
    public $sku;

    /**
     * @var string
     *
     * @ES\Property(name="title", type="string", options={"searchAnalyzer"="standard"})
     */
    public $title;

    /**
     * @var string
     *
     * @ES\Property(name="description", type="string")
     */
    public $description;

    /**
     * @var int
     *
     * @ES\Property(name="total_rating", type="integer")
     */
    public $totalRating;

    /**
     * @var string
     *
     * @ES\Property(name="location", type="geo_point")
     */
    public $location;

    /**
     * @var string Image URL.
     *
     * @ES\Property(name="image", type="string")
     */
    public $image;

    /**
     * @var string
     *
     * @ES\Property(name="thumb", type="string", options={"index"="no"})
     */
    public $thumb;

    /**
     * @var string
     *
     * @ES\Property(name="icon", type="string", options={"index"="no"})
     */
    public $icon;

    /**
     * @var string
     *
     * @ES\Property(name="category", type="string", options={"indexAnalyzer"="pathAnalyzer"})
     */
    public $category;

    /**
     * @var string
     *
     * @ES\Property(name="category_title", type="string", options={"indexAnalyzer"="pathAnalyzer"})
     */
    public $categoryTitle;

    /**
     * @var string
     *
     * @ES\Property(name="category_id", type="string", options={"index"="not_analyzed"})
     */
    public $categoryId;

    /**
     * @var string
     *
     * @ES\Property(name="main_category", type="string", options={"index"="not_analyzed"})
     */
    public $mainCategory;

    /**
     * @var string
     *
     * @ES\Property(name="attributes", type="string", options={"index"="no"})
     */
    public $attributes;

    /**
     * @var string
     *
     * @ES\Property(name="manufacturer", type="string", options={"index"="not_analyzed"})
     */
    public $manufacturer;

    /**
     * @var string
     *
     * @ES\Property(name="long_description", type="string", options={"index"="no"})
     */
    public $longDescription;

    /**
     * @var ProductReview
     *
     * @ES\Embedded(class="ONGRDemoBundle:ProductReview")
     */
    public $reviews;

    /**
     * @var ProductOrigin
     *
     * @ES\Embedded(class="ONGRDemoBundle:ProductOrigin")
     */
    public $origin;

    /**
     * @var string
     *
     * @ES\Property(name="grape", type="string", options={"index"="not_analyzed"})
     */
    public $grape;

    /**
     * @var float
     *
     * @ES\Property(name="alcohol_level", type="float")
     */
    public $alcoholLevel;

    /**
     * @var string
     *
     * @ES\Property(name="wine_style", type="string", options={"index"="not_analyzed"})
     */
    public $wineStyle;

    /**
     * @var string
     *
     * @ES\Property(name="wine_colour", type="string", options={"index"="not_analyzed"})
     */
    public $wineColour;

    /**
     * @var string
     *
     * @ES\Property(name="price", type="string", options={"index"="not_analyzed"})
     */
    public $price;
}
