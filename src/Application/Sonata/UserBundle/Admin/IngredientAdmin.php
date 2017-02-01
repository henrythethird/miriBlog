<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class IngredientAdmin extends AbstractAdmin {
	protected function configureFormFields(FormMapper $form) {
		$form->add('name', TextType::class);
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper->add('name');
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper->addIdentifier('name');
	}
}