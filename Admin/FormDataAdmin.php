<?php

namespace Alengo\Bundle\AlengoFormBundle\Admin;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItem;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItemCollection;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;

class FormDataAdmin extends Admin
{
    const FORM_DATA_LIST_VIEW = 'app.form_datas_list';

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
            ->addListAdapters(['table']);

        $viewCollection->add($listView);
    }
}