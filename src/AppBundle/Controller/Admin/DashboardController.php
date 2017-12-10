<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Image;

class DashboardController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard_list")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository('AppBundle:Image')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $images, /* query NOT result */
            $request->query->getInt('page', 1),
            10
        );


        return $this->render('AppBundle:Admin\Images:index.html.twig', array('pagination' => $pagination));


    }

    /**
     * @Route("/dashboard/create", name="create_image")
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();

        $image = new Image();

        if($request->isMethod("POST") && $request->get('title')!=null && $request->get('description')!=null
            && $request->get('path')!=null && $request->get('allowedDays')!=null)
        {
            $image->setTitle($request->get('title'));
            $image->setDescription($request->get('description'));
            $image->setPath($request->get('path'));
            $image->setAllowedDays($request->get('allowedDays'));
            $image->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();
            return $this->redirectToRoute('dashboard_list');
        }


        return $this->render('AppBundle:Admin\Images:create.html.twig');
    }

    /**
     * @Route("/dashboard/update/{id}", name="update_image")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('AppBundle:Image')->find($id);


        if($request->isMethod("POST") && $request->get('title')!=null && $request->get('description')!=null
            && $request->get('path')!=null && $request->get('allowedDays')!=null)
        {
            $image->setTitle($request->get('title'));
            $image->setDescription($request->get('description'));
            $image->setPath($request->get('path'));
            $image->setAllowedDays($request->get('allowedDays'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();
            return $this->redirectToRoute('dashboard_list');
        }


        return $this->render('AppBundle:Admin\Images:update.html.twig', array(
            'image' => $image
        ));
    }

    /**
     * @Route("/dashboard/delete/{id}", name="delete_image")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository("AppBundle:Image")->find($id);
        $em->remove($image);
        $em->flush();
        return $this->redirectToRoute('dashboard_list');
    }

}
