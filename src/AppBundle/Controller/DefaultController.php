<?php
/**
 * Default controller class.
 *
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DefaultController.
 *
 */
class DefaultController extends Controller
{
    /**
     * Index action.
     *
     * @Route("/hello/{name}")
     *
     * @param string $name Name
     * @return Response A Response instance
     */
    public function indexAction($name)
    {
        return $this->render(
            'AppBundle:Default:index.html.twig',
            array('name' => $name)
        );
    }

}
