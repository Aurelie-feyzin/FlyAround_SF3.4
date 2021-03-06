<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Site;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Site controller.
 *
 * @Route("site")
 */
class SiteController extends Controller
{
    /**
     * Lists all site entities.
     *
     * @Route("/", name="site_index", methods="GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sites = $em->getRepository('AppBundle:Site')->findAll();

        return $this->render('site/index.html.twig', array(
            'sites' => $sites,
        ));
    }

    /**
     * Finds and displays a site entity.
     *
     * @Route("/{id}", name="site_show", methods="GET")
     */
    public function showAction(Site $site)
    {

        return $this->render('site/show.html.twig', array(
            'site' => $site,
        ));
    }
}
