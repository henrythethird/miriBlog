<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RecipeAdmin extends AbstractAdmin {
	protected function configureFormFields(FormMapper $form) {
		$form
			->add('title', 'text', [
				'required' => false
			])
			->add('feedsNPeople', 'text', [
				'required' => false
			])
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
			->add('content', 'sonata_simple_formatter_type', [
				'required' => false,
				'format' => 'richhtml',
				'ckeditor_context' => 'default',
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