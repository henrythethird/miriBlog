<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RecipeAdmin extends Admin {
	protected function configureFormFields(FormMapper $form) {
		$form
			->add('title', 'text', [
				'required' => false
			])
			->add('feedsNPeople')
			->add('recipeIngredients', 'sonata_type_collection', [
				'by_reference' => false
			], [
				'edit' => 'inline',
				'inline' => 'table',
				'sortable' => 'position',
			])
			->add('steps', 'sonata_type_collection', [
				'by_reference' => false
			], [
				'edit' => 'inline',
				'inline' => 'table',
				'sortable' => 'position',
			])
		;
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('title')
			->add('post')
			->add('feedsNPeople')
		;
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->addIdentifier('title')
			->addIdentifier('post')
		;
	}
}