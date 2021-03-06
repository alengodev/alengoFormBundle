<?php

namespace Alengo\Bundle\AlengoFormBundle\Controller\Admin;


use Alengo\Bundle\AlengoFormBundle\Api\FormData as FormDataApi;
use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;
use Alengo\Bundle\AlengoFormBundle\Service\SaveFormService;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use HandcraftedInTheAlps\RestRoutingBundle\Controller\Annotations\RouteResource;
use Sulu\Component\Rest\AbstractRestController;
use Sulu\Component\Rest\Exception\EntityNotFoundException;
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

    /**
     * @var SaveFormService
     */
    private SaveFormService $formService;

    public function __construct(
        ViewHandlerInterface                $viewHandler,
        TokenStorageInterface               $tokenStorage,
        FieldDescriptorFactoryInterface     $fieldDescriptorFactory,
        DoctrineListBuilderFactoryInterface $listBuilderFactory,
        RestHelperInterface                 $restHelper,
        FormDataRepository                  $repository,
        SaveFormService                     $formService
    )
    {

        parent::__construct($viewHandler, $tokenStorage);

        $this->viewHandler = $viewHandler;
        $this->fieldDescriptorFactory = $fieldDescriptorFactory;
        $this->listBuilderFactory = $listBuilderFactory;
        $this->restHelper = $restHelper;
        $this->repository = $repository;
        $this->formService = $formService;
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
            $listBuilder->getLimit() ?? 0,
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

    public function putAction(int $id, Request $request): Response
    {
        $entity = $this->repository->findById($id)[0];
        if (!$entity) {
            throw new NotFoundHttpException();
        }

        $updatedEntity = $this->formService->updateFormData($entity, $request->request->all());
        $apiEntity = $this->generateFormDataApiEntity($updatedEntity, 'en');
        $view = $this->generateViewContent($apiEntity);

        return $this->handleView($view);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteAction(int $id): Response
    {
        try {
            $this->repository->remove($id);
        } catch (\Exception $tnfe) {
            throw new EntityNotFoundException(self::$entityName, $id);
        }

        return $this->handleView($this->view());
    }
}