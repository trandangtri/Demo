<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\DemoMagentoBundle\Cart;

use ONGR\ElasticsearchBundle\ORM\Manager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Handles with cart.
 */
class Cart
{
    /**
     * Name of the cookie where cart data is saved.
     */
    const CART_DATA_COOKIE_NAME = 'ongr_cart';

    /**
     * Parameter name for syncing with magento.
     */
    const CART_DATA_SYNC_PARAM_NAME = 'OngrProducts';

    /**
     * Parameter name for syncing with magento.
     */
    const CART_BACK_URL_PARAM_NAME = 'OngrUrl';

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var string
     */
    private $magentoUrl;

    /**
     * @var Manager
     */
    private $manager;

    /**
     * @var array
     */
    private $cartContent;

    /**
     * Constructs request to update cart in magento.
     *
     * @return RedirectResponse
     */
    public function getUpdateResponse()
    {
        $url = $this->getMagentoUrl() . '?'
            . http_build_query(
                [
                    self::CART_DATA_SYNC_PARAM_NAME => $this->getCartContent(),
                    self::CART_BACK_URL_PARAM_NAME => $this->getBackUrl(),
                ]
            );

        return new RedirectResponse($url);
    }

    /**
     * Url magento should redirect after adding products.
     *
     * @return string
     */
    private function getBackUrl()
    {
        return $this->getRouter()->generate('ongr_cart', [], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * Gets documents of cart products.
     *
     * @return array
     */
    public function getCartDocuments()
    {
        $cartContents = $this->getCartContent();
        $repository = $this->getManager()->getRepository('ONGRMagentoConnectorBundle:ProductDocument');

        $documents = [];

        foreach ($cartContents as $id => $quantity) {
            $documents[] = ['document' => $repository->find($id), 'quantity' => $quantity];
        }

        return $documents;
    }

    /**
     * @return array
     */
    public function getCartContent()
    {
        if ($this->cartContent === null) {
            $request = $this->getRequestStack()->getCurrentRequest();
            $content = json_decode($request->cookies->get(self::CART_DATA_COOKIE_NAME, '[]'), true);
            $this->cartContent = $this->cleanContent($content);
        }

        return $this->cartContent;
    }

    /**
     * Ensures contents are valid.
     *
     * @param mixed $content
     *
     * @return array
     */
    private function cleanContent($content)
    {
        if (!is_array($content)) {
            return [];
        }

        foreach ($content as $id => $quantity) {
            if (!is_numeric($quantity)) {
                unset($content[$id]);
            }
        }

        return $content;
    }

    /**
     * @param array $cartContent
     *
     * @return $this
     */
    public function setCartContent($cartContent)
    {
        $this->cartContent = $cartContent;

        return $this;
    }

    /**
     * Adds product to cart.
     *
     * @param int|string $id
     * @param int        $quantity
     *
     * @return $this
     */
    public function addProduct($id, $quantity = 1)
    {
        $content = $this->getCartContent();

        if (isset($content[$id])) {
            $content[$id] += $quantity;
        } else {
            $content[$id] = $quantity;
        }

        $this->setCartContent($content);

        return $this;
    }

    /**
     * Removes product from cart.
     *
     * @param int|string $id
     *
     * @return $this
     */
    public function removeProduct($id)
    {
        $content = $this->getCartContent();

        if (isset($content[$id])) {
            unset($content[$id]);
            $this->setCartContent($content);
        }

        return $this;
    }

    /**
     * @return RequestStack
     */
    public function getRequestStack()
    {
        return $this->requestStack;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return $this
     */
    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;

        return $this;
    }

    /**
     * @return Manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param Manager $manager
     *
     * @return $this
     */
    public function setManager(Manager $manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return string
     */
    public function getMagentoUrl()
    {
        return $this->magentoUrl;
    }

    /**
     * @param string $magentoUrl
     *
     * @return $this
     */
    public function setMagentoUrl($magentoUrl)
    {
        $this->magentoUrl = $magentoUrl;

        return $this;
    }

    /**
     * @return UrlGeneratorInterface
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param UrlGeneratorInterface $router
     *
     * @return $this
     */
    public function setRouter(UrlGeneratorInterface $router)
    {
        $this->router = $router;

        return $this;
    }
}
