<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RecipeIngredientAdmin extends AbstractAdmin {
	protected function configureFormFields(FormMapper $form) {
		$form
			->add('ingredient', 'sonata_type_model', [
				'property' => 'name',
			])
			->add('amount', null, [
				'required' => false
			])
			->add('unit', TextType::class, [
				'required' => false
			])
			->add('comment', TextType::class, [
				'required' => false
			])
			->add('position', 'hidden')
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