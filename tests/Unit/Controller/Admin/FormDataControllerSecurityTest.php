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

namespace Alengo\Bundle\AlengoFormBundle\Tests\Unit\Controller\Admin;

use Alengo\Bundle\AlengoFormBundle\Controller\Admin\FormDataController;
use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;
use Alengo\Bundle\AlengoFormBundle\Service\SaveFormService;
use FOS\RestBundle\View\ViewHandlerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SecurityBundle\EventListener\SuluSecurityListener;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactoryInterface;
use Sulu\Component\Rest\ListBuilder\Metadata\FieldDescriptorFactoryInterface;
use Sulu\Component\Rest\RestHelperInterface;
use Sulu\Component\Security\Authorization\PermissionTypes;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;
use Sulu\Component\Security\Authorization\SecurityCondition;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * The admin API holds every form submission (names, emails, all fields). Sulu checks permissions only for controllers
 * implementing SecuredControllerInterface — without it any logged-in admin user could list, export, edit and delete
 * all submissions, whatever the role says.
 */
#[CoversClass(FormDataController::class)]
final class FormDataControllerSecurityTest extends TestCase
{
    /**
     * @return iterable<string, array{string, string, string}>
     */
    public static function actions(): iterable
    {
        yield 'list / CSV export' => ['GET', 'cgetAction', PermissionTypes::VIEW];
        yield 'show' => ['GET', 'getAction', PermissionTypes::VIEW];
        yield 'edit' => ['PUT', 'putAction', PermissionTypes::EDIT];
        yield 'delete' => ['DELETE', 'deleteAction', PermissionTypes::DELETE];
    }

    #[DataProvider('actions')]
    public function testEveryActionRequiresItsFormDataPermission(string $method, string $action, string $permission): void
    {
        $checker = $this->createMock(SecurityCheckerInterface::class);
        $checker->expects(self::once())
            ->method('checkPermission')
            ->with(
                self::callback(static fn (SecurityCondition $condition): bool => FormData::SECURITY_CONTEXT === $condition->getSecurityContext()),
                $permission,
            )
            ->willReturn(true);

        new SuluSecurityListener($checker)->onKernelController($this->event($method, $action));
    }

    #[DataProvider('actions')]
    public function testMissingPermissionStopsTheAction(string $method, string $action, string $permission): void
    {
        $checker = $this->createStub(SecurityCheckerInterface::class);
        $checker->method('checkPermission')->willThrowException(new AccessDeniedException(\sprintf('Permission "%s" is missing.', $permission)));

        $this->expectException(AccessDeniedException::class);

        new SuluSecurityListener($checker)->onKernelController($this->event($method, $action));
    }

    private function event(string $method, string $action): ControllerEvent
    {
        $controller = new FormDataController(
            $this->createStub(ViewHandlerInterface::class),
            $this->createStub(FieldDescriptorFactoryInterface::class),
            $this->createStub(DoctrineListBuilderFactoryInterface::class),
            $this->createStub(RestHelperInterface::class),
            $this->createStub(FormDataRepository::class),
            $this->createStub(SaveFormService::class),
        );

        /** @var callable $callable controller + action, as the router resolves it (the listener needs the array form) */
        $callable = [$controller, $action];

        return new ControllerEvent(
            $this->createStub(HttpKernelInterface::class),
            $callable,
            Request::create('/admin/api/form-datas/1', $method),
            HttpKernelInterface::MAIN_REQUEST,
        );
    }
}
