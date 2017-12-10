<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Repository\ImageRepository;

class ImagesController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function listAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository('AppBundle:Image')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $images,
            $request->query->getInt('page', 1),
            10
        );


        return $this->render('AppBundle:Images:list.html.twig', array('pagination' => $pagination));

    }

    /**
     * @Route("image/details/{id}", name="image_details")
     */
    public function detailsAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('AppBundle:Image')->find($id);

        return $this->render('AppBundle:Images:details.html.twig', array(
            'image' => $image
        ));
    }

    /**
     * @Route("image/search", name="image_search")
     */
    public function searchAction(Request $request)
    {
        if($request->isMethod("POST") && $request->get('keyword')!=null)
        {
            $keyword = $request->get('keyword');


        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository('AppBundle:Image')->searchByTitle($keyword);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $images,
            $request->query->getInt('page', 1)/*page number*/,
            5
        );

        return $this->render('AppBundle:Images:list.html.twig', array('pagination' => $pagination));
        }
        return $this->redirectToRoute('home');
    }



    /**
     * @Route("image/sort/{sortBy}", name="image_sorted")
     */
    public function sortAction($sortBy=null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($sortBy == 'title')
        {
            $images = $em->getRepository('AppBundle:Image')->sortByTitle();
        }
        else if ($sortBy == 'dateOfCreation')
        {
            $images = $em->getRepository('AppBundle:Image')->sortByCreationDate();
        }
        else
        {
            $images = $em->getRepository('AppBundle:Image')->sortByAllowedDays();
        }



        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $images,
            $request->query->getInt('page', 1)/*page number*/,
            5
        );


        return $this->render('AppBundle:Images:list.html.twig', array('pagination' => $pagination));
    }


}
