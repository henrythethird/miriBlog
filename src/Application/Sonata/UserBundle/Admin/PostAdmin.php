<?php

namespace Application\Sonata\UserBundle\Admin;

use AppBundle\Entity\Category;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostAdmin extends Admin {
	protected function configureFormFields(FormMapper $form) {
		$form
			->add('title', TextType::class)
			->add('description', TextareaType::class)
			->add('content', 'sonata_simple_formatter_type', [
				'format' => 'richhtml',
				'ckeditor_context' => 'default',
			])
			->add('category', EntityType::class, [
				'class' => Category::class
			])
			->add('picture', 'sonata_media_type', [
				'provider' => 'sonata.media.provider.image',
				'context'  => 'default'
			])
			->add('datePublished', 'sonata_type_datetime_picker')
			->add('postIngredients', 'sonata_type_collection', [
				'by_reference' => false
			], [
				'edit' => 'inline',
				'inline' => 'table',
			])
			->add('steps', 'sonata_type_collection', [
				'by_reference' => false
			], [
				'edit' => 'inline',
				'inline' => 'table',
			])
		;
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper->add('title');
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper->addIdentifier('title')
			->addIdentifier('datePublished', 'date', [
				'pattern' => 'Y-m-d'
			])
			;
	}
}