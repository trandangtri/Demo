<?php

namespace ONGR\DemoMagentoBundle\Controller;

use ONGR\ElasticsearchBundle\ORM\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

/**
 * Cart Controller.
 */
class CartController extends Controller
{
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var Manager
     */
    private $manager;

    /**
     * Index action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function cartAction(Request $request)
    {
        $cartContents = json_decode($request->cookies->get('ongr_cart', '[]'), true);

        $documents = $this->getDocumentsFromCart($cartContents);

        return new Response(
            $this->getTemplating()->render(
                'ONGRDemoMagentoBundle::cart.html.twig',
                [
                    'cart' => $documents,
                ]
            )
        );
    }

    /**
     * @param array $cartContents
     *
     * @return array
     */
    private function getDocumentsFromCart($cartContents)
    {
        $repository = $this->getManager()->getRepository('ONGRMagentoConnectorBundle:ProductDocument');
        $documents = [];

        foreach ($cartContents as $id => $quantity) {
            $documents[] = ['document' => $repository->find($id), 'quantity' => $quantity];
        }

        return $documents;
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
}