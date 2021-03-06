<?php
/**
 * Tags controller class.
 *
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Tag;
use AppBundle\Form\TagType;
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
 * Class TagsController.
 *
 * @Route(service="app.tags_controller")
 *
 */
class TagsController
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
     * Model object.
     *
     * @var ObjectRepository $model
     */
    private $model;

    /**
     * Form factory.
     *
     * @var FormFactory $formFactory
     */
    private $formFactory;

    /**
     * TagsController constructor.
     *
     * @param Translator $translator Translator
     * @param EngineInterface $templating Templating engine
     * @param Session $session Session
     * @param RouterInterface $router
     * @param ObjectRepository $model Model object
     * @param FormFactory $formFactory Form factory
     */
    public function __construct(
        TranslatorInterface $translator,
        EngineInterface $templating,
        Session $session,
        RouterInterface $router,
        ObjectRepository $model,
        FormFactory $formFactory
    ) {
        $this->translator = $translator;
        $this->templating = $templating;
        $this->session = $session;
        $this->router = $router;
        $this->model = $model;
        $this->formFactory = $formFactory;
    }

    /**
     * Index action.
     *
     * @Route("/tags", name="tags")
     * @Route("/tags/")
     *
     * @throws NotFoundHttpException
     * @return Response A Response instance
     */
    public function indexAction()
    {
        $tags = $this->model->findAll();
        if (!$tags) {
            throw new NotFoundHttpException(
                $this->translator->trans('tags.messages.tags_not_found')
            );
        }
        return $this->templating->renderResponse(
            'AppBundle:Tags:index.html.twig',
            array('tags' => $tags)
        );
    }

    /**
     * View action.
     *
     * @Route("/tags/view/{id}", name="tags-view")
     * @Route("/tags/view/{id}/")
     * @ParamConverter("tag", class="AppBundle:Tag")
     *
     * @param Tag $tag Tag entity
     * @throws NotFoundHttpException
     * @return Response A Response instance
     */
    public function viewAction(Tag $tag = null)
    {
        if (!$tag) {
            throw new NotFoundHttpException(
                $this->translator->trans('tags.messages.tag_not_found')
            );
        }
        return $this->templating->renderResponse(
            'AppBundle:Tags:view.html.twig',
            array('tag' => $tag)
        );
    }

    /**
     * Add action.
     *
     * @Route("/tags/add", name="tags-add")
     * @Route("/tags/add/")
     *
     * @param Request $request
     * @return Response A Response instance
     */
    public function addAction(Request $request)
    {
        $tagForm = $this->formFactory->create(
            TagType::class,
            null,
            array(
                'validation_groups' => 'tag-default'
            )
        );

        $tagForm->handleRequest($request);

        if ($tagForm->isValid()) {
            $tag = $tagForm->getData();
            $this->model->save($tag);
            $this->session->getFlashBag()->set(
                'success',
                $this->translator->trans('tags.messages.success.add')
            );
            return new RedirectResponse(
                $this->router->generate('tags')
            );
        }

        return $this->templating->renderResponse(
            'AppBundle:Tags:add.html.twig',
            array('form' => $tagForm->createView())
        );
    }

    /**
     * Edit action.
     *
     * @Route("/tags/edit/{id}", name="tags-edit")
     * @Route("/tags/edit/{id}/")
     * @ParamConverter("tag", class="AppBundle:Tag")
     *
     * @param Tag $tag Tag entity
     * @param Request $request
     * @return Response A Response instance
     */
    public function editAction(Request $request, Tag $tag = null)
    {
        if (!$tag) {
            $this->session->getFlashBag()->set(
                'warning',
                $this->translator->trans('tags.messages.tag_not_found')
            );
            return new RedirectResponse(
                $this->router->generate('tags-add')
            );
        }

        $tagForm = $this->formFactory->create(
            TagType::class,
            $tag,
            array(
                'validation_groups' => 'tag-default'
            )
        );

        $tagForm->handleRequest($request);

        if ($tagForm->isValid()) {
            $tag = $tagForm->getData();
            $this->model->save($tag);
            $this->session->getFlashBag()->set(
                'success',
                $this->translator->trans('tags.messages.success.edit')
            );
            return new RedirectResponse(
                $this->router->generate('tags')
            );
        }

        return $this->templating->renderResponse(
            'AppBundle:Tags:edit.html.twig',
            array('form' => $tagForm->createView())
        );

    }

    /**
     * Delete action.
     *
     * @Route("/tags/delete/{id}", name="tags-delete")
     * @Route("/tags/delete/{id}/")
     * @ParamConverter("tag", class="AppBundle:Tag")
     *
     * @param Tag $tag Tag entity
     * @param Request $request
     * @return Response A Response instance
     */
    public function deleteAction(Request $request, Tag $tag = null)
    {
        if (!$tag) {
            $this->session->getFlashBag()->set(
                'warning',
                $this->translator->trans('tags.messages.tag_not_found')
            );
            return new RedirectResponse(
                $this->router->generate('tags')
            );
        }

        $tagForm = $this->formFactory->create(
            TagType::class,
            $tag,
            array(
                'validation_groups' => 'tag-delete'
            )
        );

        $tagForm->handleRequest($request);

        if ($tagForm->isValid()) {
            $tag = $tagForm->getData();
            $this->model->delete($tag);
            $this->session->getFlashBag()->set(
                'success',
                $this->translator->trans('tags.messages.success.delete')
            );
            return new RedirectResponse(
                $this->router->generate('tags')
            );
        }

        return $this->templating->renderResponse(
            'AppBundle:Tags:delete.html.twig',
            array('form' => $tagForm->createView())
        );

    }

}
