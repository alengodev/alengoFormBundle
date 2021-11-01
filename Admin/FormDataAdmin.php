<?php

namespace Alengo\Bundle\AlengoFormBundle\Admin;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItem;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItemCollection;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;

class FormDataAdmin extends Admin
{
    const FORM_DATA_LIST_VIEW = 'app.form_datas_list';
    const FORM_DATA_FORM_KEY = 'form_data_details';
    const FORM_DATA_ADD_FORM_VIEW = 'app.form_data_add_form';
    const FORM_DATA_EDIT_FORM_VIEW = 'app.form_data_edit_form';

    /**
     * @var ViewBuilderFactoryInterface
     */
    private $viewBuilderFactory;

    public function __construct(ViewBuilderFactoryInterface $viewBuilderFactory)
    {
        $this->viewBuilderFactory = $viewBuilderFactory;
    }

    public function configureNavigationItems(NavigationItemCollection $navigationItemCollection): void
    {
        $formDataNavigationItem = new NavigationItem('app.form_datas');
        $formDataNavigationItem->setView(static::FORM_DATA_LIST_VIEW);
        $formDataNavigationItem->setIcon('su-snippet');
        $formDataNavigationItem->setPosition(30);

        $navigationItemCollection->add($formDataNavigationItem);
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        $listView = $this->viewBuilderFactory->createListViewBuilder(static::FORM_DATA_LIST_VIEW, '/form_datas')
            ->setResourceKey(FormData::RESOURCE_KEY)
            ->setListKey('form_datas')
            ->setTitle('app.form_datas')
            ->addListAdapters(['table'])
            ->setAddView(static::FORM_DATA_ADD_FORM_VIEW)
            ->setEditView(static::FORM_DATA_EDIT_FORM_VIEW)
            ->addToolbarActions([new ToolbarAction('sulu_admin.delete')]);

        $viewCollection->add($listView);

        $editFormView = $this->viewBuilderFactory->createResourceTabViewBuilder(static::FORM_DATA_EDIT_FORM_VIEW, '/form_datas/:id')
            ->setResourceKey(FormData::RESOURCE_KEY)
            ->setBackView(static::FORM_DATA_LIST_VIEW);

        $viewCollection->add($editFormView);

        $editDetailsFormView = $this->viewBuilderFactory->createFormViewBuilder(static::FORM_DATA_EDIT_FORM_VIEW . '.details', '/details')
            ->setResourceKey(FormData::RESOURCE_KEY)
            ->setFormKey(static::FORM_DATA_FORM_KEY)
            ->setTabTitle('sulu_admin.details')
            ->addToolbarActions([new ToolbarAction('sulu_admin.save'), new ToolbarAction('sulu_admin.delete')])
            ->setParent(static::FORM_DATA_EDIT_FORM_VIEW);

        $viewCollection->add($editDetailsFormView);
    }
}