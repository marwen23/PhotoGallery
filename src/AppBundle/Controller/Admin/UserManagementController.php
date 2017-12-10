<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UserManagementController extends Controller
{
    /**
     * @Route("/dashboard/manageusers/index", name="user_list")
     */
    public function indexAction()
    {


        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();


        return $this->render('AppBundle:Admin\UserManagement:index.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @Route("dashboard/manageusers/edit/{id}",name="update_user")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);


        if ($request->isMethod("POST") && $request->get('firstName') != null && $request->get('lastName') != null
            && $request->get('username') != null && $request->get('email') != null && $request->get('role') != null) {
            $user->setFirstName($request->get('firstName'));
            $user->setLastName($request->get('lastName'));
            $user->setUsername($request->get('username'));
            $user->setUsernameCanonical($request->get('username'));
            $user->setEmail($request->get('email'));
            $user->setEmailCanonical($request->get('email'));


            if ($request->get('role') == 'ROLE_ADMIN') {
                $user->setRoles(array(null));
                $user->setRoles(array("ROLE_ADMIN"));
            }

            if ($request->get('role') == 'ROLE_USER') {
                $user->setRoles(array(null));
                $user->setRoles(array("ROLE_USER"));
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_list');
        }


        return $this->render('AppBundle:Admin\UserManagement:edit.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * @Route("/dashboard/manageusers/delete/{id}", name="delete_user")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository("AppBundle:User")->find($id);
        $em->remove($image);
        $em->flush();
        return $this->redirectToRoute('user_list');
    }


}
