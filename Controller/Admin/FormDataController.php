<?php

namespace Alengo\Bundle\AlengoFormBundle\Controller\Admin;


use Alengo\Bundle\AlengoFormBundle\Api\FormData as FormDataApi;
use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use HandcraftedInTheAlps\RestRoutingBundle\Controller\Annotations\RouteResource;
use Sulu\Component\Rest\AbstractRestController;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactoryInterface;
use Sulu\Component\Rest\ListBuilder\Metadata\FieldDescriptorFactoryInterface;
use Sulu\Component\Rest\ListBuilder\PaginatedRepresentation;
use Sulu\Component\Rest\RestHelperInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


/**
 * @RouteResource("formData")
 */
class FormDataController extends AbstractRestController
{
    /**
     * @var ViewHandlerInterface
     */
    private $viewHandler;

    /**
     * @var FieldDescriptorFactoryInterface
     */
    private $fieldDescriptorFactory;

    /**
     * @var DoctrineListBuilderFactoryInterface
     */
    private $listBuilderFactory;

    /**
     * @var RestHelperInterface
     */
    private $restHelper;

    /**
     * @var FormDataRepository
     */
    private FormDataRepository $repository;

    public function __construct(
        ViewHandlerInterface                $viewHandler,
        TokenStorageInterface               $tokenStorage,
        FieldDescriptorFactoryInterface     $fieldDescriptorFactory,
        DoctrineListBuilderFactoryInterface $listBuilderFactory,
        RestHelperInterface                 $restHelper,
        FormDataRepository                  $repository
    )
    {

        parent::__construct($viewHandler, $tokenStorage);

        $this->viewHandler = $viewHandler;
        $this->fieldDescriptorFactory = $fieldDescriptorFactory;
        $this->listBuilderFactory = $listBuilderFactory;
        $this->restHelper = $restHelper;
        $this->repository = $repository;
    }

    public function cgetAction(): Response
    {
        $fieldDescriptors = $this->fieldDescriptorFactory->getFieldDescriptors('form_datas');
        $listBuilder = $this->listBuilderFactory->create(FormData::class);
        $this->restHelper->initializeListBuilder($listBuilder, $fieldDescriptors);

        $listRepresentation = new PaginatedRepresentation(
            $listBuilder->execute(),
            FormData::RESOURCE_KEY,
            $listBuilder->getCurrentPage(),
            $listBuilder->getLimit(),
            $listBuilder->count()
        );

        return $this->viewHandler->handle(View::create($listRepresentation));
    }

    public function getAction(int $id, Request $request): Response
    {
        if (!$entity = $this->repository->findById($id)[0]) {
            throw new NotFoundHttpException();
        }

        $apiEntity = $this->generateFormDataApiEntity($entity, 'en');

        $view = $this->generateViewContent($apiEntity);

        return $this->handleView($view);
    }

    protected function generateFormDataApiEntity(FormData $entity, string $locale): FormDataApi
    {
        return new FormDataApi($entity, $locale);
    }

    protected function generateViewContent(FormDataApi $entity): View
    {
        $view = $this->view($entity);
        $context = new Context();
        $context->setGroups(['fullFormData']);

        return $view->setContext($context);
    }
}