<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RecipeIngredientAdmin extends Admin {
	protected function configureFormFields(FormMapper $form) {
		$form
			->add('ingredient')
			->add('amount')
			->add('unit', TextType::class, ['required' => false])
			->add('comment', TextType::class, ['required' => false])
		;
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