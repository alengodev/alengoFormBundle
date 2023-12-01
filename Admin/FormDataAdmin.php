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

namespace Alengo\Bundle\AlengoFormBundle\Admin;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItem;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItemCollection;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;
use Sulu\Component\Security\Authorization\PermissionTypes;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;
use Sulu\Component\Webspace\Manager\WebspaceManagerInterface;

class FormDataAdmin extends Admin
{
    final public const FORM_DATA_LIST_VIEW = 'app.form_datas_list';
    final public const FORM_DATA_FORM_KEY = 'form_data_details';
    final public const FORM_DATA_ADD_FORM_VIEW = 'app.form_data_add_form';
    final public const FORM_DATA_EDIT_FORM_VIEW = 'app.form_data_edit_form';

    public function __construct(private readonly ViewBuilderFactoryInterface $viewBuilderFactory, private readonly SecurityCheckerInterface $securityChecker, private readonly WebspaceManagerInterface $webspaceManager)
    {
    }

    public function configureNavigationItems(NavigationItemCollection $navigationItemCollection): void
    {
        if ($this->securityChecker->hasPermission(FormData::SECURITY_CONTEXT, PermissionTypes::VIEW)) {
            $formDataNavigationItem = new NavigationItem('app.form_datas');
            $formDataNavigationItem->setView(static::FORM_DATA_LIST_VIEW);
            $formDataNavigationItem->setIcon('fa-file-text-o');
            $formDataNavigationItem->setPosition(30);

            $navigationItemCollection->add($formDataNavigationItem);
        }
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        $locales = $this->webspaceManager->getAllLocales();

        $formToolbarActions = [];
        $listToolbarActions = [];

        if ($this->securityChecker->hasPermission(FormData::SECURITY_CONTEXT, PermissionTypes::EDIT)) {
            $formToolbarActions[] = new ToolbarAction('sulu_admin.save');
        }

        if ($this->securityChecker->hasPermission(FormData::SECURITY_CONTEXT, PermissionTypes::DELETE)) {
            $formToolbarActions[] = new ToolbarAction('sulu_admin.delete');
            $listToolbarActions[] = new ToolbarAction('sulu_admin.delete');
        }

        if ($this->securityChecker->hasPermission(FormData::SECURITY_CONTEXT, PermissionTypes::VIEW)) {
            $listToolbarActions[] = new ToolbarAction('sulu_admin.export');
        }

        if ($this->securityChecker->hasPermission(FormData::SECURITY_CONTEXT, PermissionTypes::VIEW)) {
            $listView = $this->viewBuilderFactory
                ->createListViewBuilder(static::FORM_DATA_LIST_VIEW, '/form_datas/:locale')
                ->setResourceKey(FormData::RESOURCE_KEY)
                ->setListKey('form_datas')
                ->setTitle('app.form_datas')
                ->addListAdapters(['table'])
                ->addLocales($locales)
                ->setAddView(static::FORM_DATA_ADD_FORM_VIEW)
                ->setEditView(static::FORM_DATA_EDIT_FORM_VIEW)
                ->addToolbarActions($listToolbarActions);

            $viewCollection->add($listView);

            $editFormView = $this->viewBuilderFactory
                ->createResourceTabViewBuilder(static::FORM_DATA_EDIT_FORM_VIEW, '/form_datas/:locale/:id')
                ->setResourceKey(FormData::RESOURCE_KEY)
                ->addLocales($locales)
                ->setBackView(static::FORM_DATA_LIST_VIEW);

            $viewCollection->add($editFormView);

            $editDetailsFormView = $this->viewBuilderFactory
                ->createPreviewFormViewBuilder(static::FORM_DATA_EDIT_FORM_VIEW . '.details', '/details')
                ->setPreviewCondition('id != null')
                ->setResourceKey(FormData::RESOURCE_KEY)
                ->setFormKey(static::FORM_DATA_FORM_KEY)
                ->setTabTitle('sulu_admin.details')
                ->addToolbarActions($formToolbarActions)
                ->setParent(static::FORM_DATA_EDIT_FORM_VIEW);

            $viewCollection->add($editDetailsFormView);
        }
    }

    /**
     * @return mixed[]
     */
    public function getSecurityContexts(): array
    {
        return [
            self::SULU_ADMIN_SECURITY_SYSTEM => [
                'Form' => [
                    FormData::SECURITY_CONTEXT => [
                        PermissionTypes::VIEW,
                        PermissionTypes::EDIT,
                        PermissionTypes::DELETE,
                    ],
                ],
            ],
        ];
    }
}
