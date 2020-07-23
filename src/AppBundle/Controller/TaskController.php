<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

/**
 *
 * Class TaskController
 *
 * @codeCoverageIgnore
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * 
     * @return Response
     */
    public function indexAction()
    {
        $response = $this->render('task/index.html.twig');
        $response->setSharedMaxAge(200);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /**
     * @Route("/tasks", name="task_list")
     * 
     * @return Response
     */
    public function listAction()
    {
        return $this->render(
            'task/list.html.twig',
            [
                'tasks' => $this->getDoctrine()->getRepository('AppBundle:Task')->findBy(
                    array('isDone' => false),
                    array('createdAt' => 'desc'),
                    null,
                    null
                )
            ]
        );
    }

    /**
     * @Route("/tasksdone", name="task_done")
     *
     * @return Response
     */
    public function listDoneAction()
    {
        return $this->render(
            'task/list.html.twig',
            [
                'tasks' => $this->getDoctrine()->getRepository('AppBundle:Task')->findBy(
                    array('isDone' => true),
                    array('createdAt' => 'desc'),
                    null,
                    null
                )
            ]
        );
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * 
     * @Route("/tasks/todo", name="task_todo")
     */
    public function createAction(Request $request, EntityManagerInterface $em = null)
    {
        $task = new Task();
        $task->setUser($this->getUser());
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Task $task
     * @param Request $request
     * 
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @param Task $task
     * @param EntityManagerInterface $em
     * 
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        $em = $this->getDoctrine()->getManager();
        $task->toggle(!$task->isDone());
        $em->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * 
     * @param Task $task
     * @param EntityManagerInterface $em
     * 
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task, EntityManagerInterface $em = null)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')
        ->getToken()
        ->getUser();

        if ($task->getUser() == $user) {
            $em->remove($task);
            $em->flush();
    
            $this->addFlash('success', 'La tâche a bien été supprimée.');
        }

        if ($user->isAdmin() && $task->getUser() === null) {
            $em->remove($task);
            $em->flush();
    
            $this->addFlash('success', 'La tâche a bien été supprimée.');
        }

        return $this->redirectToRoute('task_list');
    }
}
