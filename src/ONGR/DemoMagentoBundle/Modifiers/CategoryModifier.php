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

use ONGR\MagentoConnectorBundle\Modifier\CategoryModifier as CategoryModifierParent;

/**
 * Modifies entities to match ongr category mapping.
 */
class CategoryModifier extends CategoryModifierParent
{
    /**
     * @var int
     */
    protected $categoryRootId = 2;
}
