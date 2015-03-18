<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\DemoMagentoBundle\Controller;

use ONGR\MagentoConnectorBundle\Magento\Cart;
use ONGR\MagentoConnectorBundle\Magento\Customer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class UserController.
 */
class CustomerController
{
    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * Action for showing logged in user info.
     *
     * @return Response
     */
    public function customerTopAction()
    {
        return new Response(
            $this->getTemplating()->render(
                'ONGRDemoMagentoBundle::customertop.html.twig',
                [
                    'userData' => $this->getCustomer()->getUserData(),
                    'cartCount' => count($this->getCart()),
                    'logoutUrl' => $this->getCustomer()->getLogoutUrl(),
                    'loginUrl' => $this->getCustomer()->getLoginUrl(),
                ]
            )
        );
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     *
     * @return $this
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;

        return $this;
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
    public function setTemplating($templating)
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
    public function setCart(Cart $cart)
    {
        $this->cart = $cart;

        return $this;
    }
}
