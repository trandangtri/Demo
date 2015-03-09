<?php

namespace ONGR\DemoMagentoBundle\Controller;

use ONGR\DemoMagentoBundle\Magento\Cart;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

/**
 * Cart Controller.
 */
class CartController
{
    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * Index action.
     *
     * @return Response
     */
    public function cartAction()
    {
        return new Response(
            $this->getTemplating()->render(
                'ONGRDemoMagentoBundle::cart.html.twig',
                [
                    'cart' => $this->getCart()->getCartDocuments(),
                    'error' => $this->getCart()->getErrorDocuments(),
                    'checkoutUrl' => $this->getCart()->getCheckoutUrl(),
                ]
            )
        );
    }

    /**
     * Action for adding product to cart.
     *
     * @param int|string $id
     * @param int        $quantity
     *
     * @return RedirectResponse
     */
    public function addAction($id, $quantity)
    {
        return $this->getCart()->addProduct($id, $quantity)->getUpdateResponse();
    }

    /**
     * @return EngineInterface
     */
    public function getTemplating()
    {
        return $this->templating;
    }

    /**
     * @param EngineInterface $templating
     *
     * @return $this
     */
    public function setTemplating(EngineInterface $templating)
    {
        $this->templating = $templating;

        return $this;
    }

    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     *
     * @return $this
     */
    public function setCart($cart)
    {
        $this->cart = $cart;

        return $this;
    }
}
