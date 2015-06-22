<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\DemoBundle\Controller;

use ONGR\DemoBundle\Document\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Controller for product page and list actions.
 */
class ProductController extends Controller
{
    /**
     * Show product page by id.
     *
     * @param string $id Product id.
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function showAction($id)
    {
        /** @var Product $product */
        $product = $this->get('es.manager.oxid')
            ->getRepository('ONGRDemoOXIDBundle:ProductDocument')
            ->find($id);

        if ($product === null) {
            throw $this->createNotFoundException('Product was not found');
        }

        return $this->documentAction($product);
    }

    /**
     * Render product document.
     *
     * @param Product $document
     *
     * @return Response
     */
    public function documentAction($document)
    {
        return $this->render(
            'ONGRDemoBundle:Product:product.html.twig',
            [
                'product' => $document,
            ]
        );
    }
}
