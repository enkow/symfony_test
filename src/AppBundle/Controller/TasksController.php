<?php
/**
 * Tasks controller class.
 *
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Doctrine\Common\Persistence\ObjectRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class TasksController.
 *
 * @Route(service="app.tasks_controller")
 *
 */
class TasksController
{
    /**
     * Translator object.
     *
     * @var Translator $translator
     */
    private $translator;

    /**
     * Template engine.
     *
     * @var EngineInterface $templating
     */
    private $templating;

    /**
     * Session object.
     *
     * @var Session $session
     */
    private $session;

    /**
     * Routing object.
     *
     * @var RouterInterface $router
     */
    private $router;

    /**
     * Tags model object.
     *
     * @var ObjectRepository $tagsModel
     */
    private $tagsModel;

    /**
     * Tasks model object.
     *
     * @var ObjectRepository $tasksModel
     */
    private $tasksModel;

    /**
     * Form factory.
     *
     * @var FormFactory $formFactory
     */
    private $formFactory;

    /**
     * TasksController constructor.
     *
     * @param Translator $translator Translator
     * @param EngineInterface $templating Templating engine
     * @param Session $session Session
     * @param RouterInterface $router
     * @param ObjectRepository $tagsModel Tags model
     * @param ObjectRepository $tasksModel Tasks model
     * @param FormFactory $formFactory Form factory
     */
    public function __construct(
        TranslatorInterface $translator,
        EngineInterface $templating,
        Session $session,
        RouterInterface $router,
        ObjectRepository $tagsModel,
        ObjectRepository $tasksModel,
        FormFactory $formFactory
    ) {
        $this->translator = $translator;
        $this->templating = $templating;
        $this->session = $session;
        $this->router = $router;
        $this->tagsModel = $tagsModel;
        $this->tasksModel = $tasksModel;
        $this->formFactory = $formFactory;
    }

    /**
     * Index action.
     *
     * @Route("/tasks", name="tasks")
     * @Route("/tasks/")
     *
     * @throws NotFoundHttpException
     * @return Response A Response instance
     */
    public function indexAction()
    {
        $tasks = $this->tasksModel->findAll();
        if (!$tasks) {
            throw new NotFoundHttpException(
                $this->translator->trans('tasks.messages.tasks_not_found')
            );
        }
        return $this->templating->renderResponse(
            'AppBundle:Tasks:index.html.twig',
            array('tasks' => $tasks)
        );
    }

    /**
     * View action.
     *
     * @Route("/tasks/view/{id}", name="tasks-view")
     * @Route("/tasks/view/{id}/")
     * @ParamConverter("task", class="AppBundle:Task")
     *
     * @param Task $task Task entity
     * @throws NotFoundHttpException
     * @return Response A Response instance
     */
    public function viewAction(Task $task)
    {
        if (!$task) {
            throw new NotFoundHttpException(
                $this->translator->trans('tasks.messages.task_not_found')
            );
        }
        return $this->templating->renderResponse(
            'AppBundle:Tasks:view.html.twig',
            array('task' => $task)
        );
    }

    /**
     * Add action.
     *
     * @Route("/tasks/add", name="tasks-add")
     * @Route("/tasks/add/")
     *
     * @param Request $request
     * @return Response A Response instance
     */
    public function addAction(Request $request)
    {
        $taskForm = $this->formFactory->create(
            TaskType::class,
            null,
            array(
                'validation_groups' => 'task-default',
                'tag_model' => $this->tagsModel
            )
        );

        $taskForm->handleRequest($request);

        if ($taskForm->isValid()) {
            $task = $taskForm->getData();
            $this->tasksModel->save($task);
            $this->session->getFlashBag()->set(
                'success',
                $this->translator->trans('tasks.messages.success.add')
            );
            return new RedirectResponse(
                $this->router->generate('tasks')
            );
        }

        return $this->templating->renderResponse(
            'AppBundle:Tasks:add.html.twig',
            array('form' => $taskForm->createView())
        );
    }

    /**
     * Edit action.
     *
     * @Route("/tasks/edit/{id}", name="tasks-edit")
     * @Route("/tasks/edit/{id}/")
     * @ParamConverter("tag", class="AppBundle:Task")
     *
     * @param Task $task Task entity
     * @param Request $request
     * @return Response A Response instance
     */
    public function editAction(Request $request, Task $task = null)
    {
        if (!$task) {
            $this->session->getFlashBag()->set(
                'warning',
                $this->translator->trans('tasks.messages.task_not_found')
            );
            return new RedirectResponse(
                $this->router->generate('tasks-add')
            );
        }

        $taskForm = $this->formFactory->create(
            TaskType::class,
            $task,
            array(
                'validation_groups' => 'task-edit',
                'tag_model' => $this->tagsModel
            )
        );

        $taskForm->handleRequest($request);

        if ($taskForm->isValid()) {
            $task = $taskForm->getData();
            $this->tasksModel->save($task, true);
            $this->session->getFlashBag()->set(
                'success',
                $this->translator->trans('tasks.messages.success.edit')
            );
            return new RedirectResponse(
                $this->router->generate('tasks')
            );
        }

        return $this->templating->renderResponse(
            'AppBundle:Tasks:edit.html.twig',
            array('form' => $taskForm->createView())
        );

    }

    /**
     * Delete action.
     *
     * @Route("/tasks/delete/{id}", name="tasks-delete")
     * @Route("/tasks/delete/{id}/")
     * @ParamConverter("tasks", class="AppBundle:Task")
     *
     * @param Task $task Task entity
     * @param Request $request
     * @return Response A Response instance
     */
    public function deleteAction(Request $request, Task $task = null)
    {
        if (!$task) {
            $this->session->getFlashBag()->set(
                'warning',
                $this->translator->trans('tasks.messages.task_not_found')
            );
            return new RedirectResponse(
                $this->router->generate('tasks')
            );
        }

        $taskForm = $this->formFactory->create(
            TaskType::class,
            $task,
            array(
                'validation_groups' => 'task-delete',
                'tag_model' => $this->tagsModel
            )
        );

        $taskForm->handleRequest($request);

        if ($taskForm->isValid()) {
            $task = $taskForm->getData();
            $this->tasksModel->delete($task);
            $this->session->getFlashBag()->set(
                'success',
                $this->translator->trans('tasks.messages.success.delete')
            );
            return new RedirectResponse(
                $this->router->generate('tasks')
            );
        }

        return $this->templating->renderResponse(
            'AppBundle:Tasks:delete.html.twig',
            array('form' => $taskForm->createView())
        );

    }

}
