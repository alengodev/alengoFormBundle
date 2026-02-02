<?php

declare(strict_types=1);

/*
 * This file is part of Alengo\Bundle\AlengoFormBundle.
 *
 * (c) alengo
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Alengo\Bundle\AlengoFormBundle\Controller\Admin;

use Alengo\Bundle\AlengoFormBundle\Api\FormData as FormDataApi;
use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;
use Alengo\Bundle\AlengoFormBundle\Service\SaveFormService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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
    private readonly ViewHandlerInterface $viewHandler;

    public function __construct(
        ViewHandlerInterface $viewHandler,
        TokenStorageInterface $tokenStorage,
        private readonly FieldDescriptorFactoryInterface $fieldDescriptorFactory,
        private readonly DoctrineListBuilderFactoryInterface $listBuilderFactory,
        private readonly RestHelperInterface $restHelper,
        private readonly FormDataRepository $repository,
        private readonly SaveFormService $formService,
    ) {
        parent::__construct($viewHandler, $tokenStorage);

        $this->viewHandler = $viewHandler;
    }

    public function cgetAction(): Response
    {
        $fieldDescriptors = $this->fieldDescriptorFactory->getFieldDescriptors('form_datas');
        $listBuilder = $this->listBuilderFactory->create(FormData::class);
        $this->restHelper->initializeListBuilder($listBuilder, $fieldDescriptors);

        $limit = (int) $listBuilder->getLimit();

        $listRepresentation = new PaginatedRepresentation(
            $listBuilder->execute(),
            FormData::RESOURCE_KEY,
            (int) $listBuilder->getCurrentPage(),
            $limit ?? 0,
            $listBuilder->count(),
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
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteAction(int $id): Response
    {
        try {
            $this->repository->remove($id);
        } catch (\Exception) {
            throw new EntityNotFoundException(self::$entityName, $id);
        }

        return $this->handleView($this->view());
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
