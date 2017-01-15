<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PostIngredientAdmin extends Admin {
	protected function configureFormFields(FormMapper $form) {
		$form
			->add('ingredient')
			->add('amount')
			->add('unit');
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper->add('ingredient');
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper->addIdentifier('ingredient');
	}
}