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
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sulu\Component\Rest\AbstractRestController;
use Sulu\Component\Rest\Exception\EntityNotFoundException;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactoryInterface;
use Sulu\Component\Rest\ListBuilder\Metadata\FieldDescriptorFactoryInterface;
use Sulu\Component\Rest\ListBuilder\PaginatedRepresentation;
use Sulu\Component\Rest\RestHelperInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FormDataController extends AbstractRestController
{
    protected static $entityName = FormData::class;

    public function __construct(
        ViewHandlerInterface $viewHandler,
        private readonly FieldDescriptorFactoryInterface $fieldDescriptorFactory,
        private readonly DoctrineListBuilderFactoryInterface $listBuilderFactory,
        private readonly RestHelperInterface $restHelper,
        private readonly FormDataRepository $repository,
        private readonly SaveFormService $formService,
    ) {
        parent::__construct($viewHandler);
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
            $limit,
            $listBuilder->count(),
        );

        return $this->handleView($this->view($listRepresentation));
    }

    public function getAction(int $id, Request $request): Response
    {
        $entity = $this->repository->find($id);
        if (null === $entity) {
            throw new NotFoundHttpException();
        }

        $apiEntity = $this->generateFormDataApiEntity($entity);
        $view = $this->generateViewContent($apiEntity);

        return $this->handleView($view);
    }

    public function putAction(int $id, Request $request): Response
    {
        $entity = $this->repository->find($id);
        if (null === $entity) {
            throw new NotFoundHttpException();
        }

        $updatedEntity = $this->formService->updateFormData($entity, $request->request->all());
        $apiEntity = $this->generateFormDataApiEntity($updatedEntity);
        $view = $this->generateViewContent($apiEntity);

        return $this->handleView($view);
    }

    public function deleteAction(int $id): Response
    {
        try {
            $this->repository->remove($id);
        } catch (\Exception) {
            throw new EntityNotFoundException(self::$entityName, $id);
        }

        return $this->handleView($this->view());
    }

    protected function generateFormDataApiEntity(FormData $entity): FormDataApi
    {
        return new FormDataApi($entity);
    }

    protected function generateViewContent(FormDataApi $entity): View
    {
        $view = $this->view($entity);
        $context = new Context();
        $context->setGroups(['fullFormData']);

        return $view->setContext($context);
    }
}
