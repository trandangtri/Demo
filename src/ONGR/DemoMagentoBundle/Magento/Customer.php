<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\DemoMagentoBundle\Magento;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Responsible for getting customer data from magento.
 */
class Customer
{
    /**
     * Name of the cookie where user data is saved.
     */
    const USER_DATA_COOKIE_NAME = 'ongr_user';

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var ParameterBag
     */
    private $userData;

    /**
     * Ensures user data is valid.
     *
     * @param mixed $data
     *
     * @return ParameterBag
     */
    private function formatUserData($data)
    {
        if (!is_array($data)) {
            $data = [];
        }

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                unset($data[$key]);
            }
        }

        return new ParameterBag($data);
    }

    /**
     * Gets user data.
     *
     * @return ParameterBag
     */
    public function getUserData()
    {
        if ($this->userData === null) {
            $request = $this->getRequestStack()->getCurrentRequest();
            $data = json_decode($request->cookies->get(self::USER_DATA_COOKIE_NAME, []), true);
            $this->userData = $this->formatUserData($data);
        }

        return $this->userData;
    }

    /**
     * @param ParameterBag $userData
     *
     * @return $this
     */
    public function setUserData(ParameterBag $userData)
    {
        $this->userData = $userData;

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
    public function setRequestStack($requestStack)
    {
        $this->requestStack = $requestStack;

        return $this;
    }
}
