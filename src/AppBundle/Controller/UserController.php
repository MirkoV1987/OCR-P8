<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserController
 */
class UserController extends AbstractController
{
    /**
     * @Route("/users", name="user_list")
     * 
     * @return Response
     */
    public function listAction()
    {
        $this->denyAccessUnlessGranted('GET', $this->getUser());

        $response = $this->render('user/list.html.twig', ['users' => $this->getDoctrine()->getRepository('AppBundle:User')->findAll()]);
        
        $response->setSharedMaxAge(200);

        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * 
     * @Route("/users/create", name="user_create")
     */
    public function createAction(Request $request, EntityManagerInterface $em = null)
    {
        $this->denyAccessUnlessGranted('ADD', $this->getUser());

        $user = new User();
        
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // @codeCoverageIgnoreStart

            $em = $this->getDoctrine()->getManager();

            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
         
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
            // @codeCoverageIgnoreEnd
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * 
     * @Route("/users/{id}/edit", name="user_edit")
     */
    public function editAction(User $user, Request $request, EntityManagerInterface $em = null)
    {
        $this->denyAccessUnlessGranted('EDIT', $this->getUser());

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $em
     * 
     * @Route("/users/{id}/delete", name="user_delete")
     */
    public function deleteAction(User $user)
    {
        $this->denyAccessUnlessGranted('REMOVE', $this->getUser());

        $em = $this->getDoctrine()->getManager();

        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'L\'utilisateur a bien été supprimé');

        return $this->redirectToRoute('user_list');
    }
}
