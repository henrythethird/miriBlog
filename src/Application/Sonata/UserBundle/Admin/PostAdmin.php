<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
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
			->add('categories', null, [], [
			    'allow_add' => true
            ])
			->add('picture', 'sonata_media_type', [
				'provider' => 'sonata.media.provider.image',
				'context'  => 'default'
			])
			->add('datePublished', 'sonata_type_datetime_picker', [
				'required' => false,
                'format' => 'dd.MM.yyyy, HH:mm',
                'attr' => [
                    'data-date-format' => 'DD.MM.YYYY, HH:mm',
                ],
			])
			->add('recipes', 'sonata_type_collection', [
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
                'format' => 'dd.MM.yyyy, HH:mm',
			])
        ;
	}
}