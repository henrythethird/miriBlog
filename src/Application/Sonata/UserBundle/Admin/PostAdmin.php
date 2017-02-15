<?php

namespace Application\Sonata\UserBundle\Admin;

use Application\Sonata\UserBundle\Form\UrlType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostAdmin extends AbstractAdmin {
	protected function configureFormFields(FormMapper $form) {
		$form
            ->with('General', [
                'class' => 'col-md-6'
            ])
                ->add('title', TextType::class)
                ->add('slug', UrlType::class, [
                    'required' => false
                ])
                ->add('datePublished', 'sonata_type_datetime_picker', [
                    'required' => false,
                    'format' => 'dd.MM.yyyy, HH:mm',
                    'attr' => [
                        'data-date-format' => 'DD.MM.YYYY, HH:mm',
                    ],
                ])
                ->add('dateMailPublished', 'sonata_type_datetime_picker', [
                    'required' => false,
                    'format' => 'dd.MM.yyyy, HH:mm',
                    'attr' => [
                        'data-date-format' => 'DD.MM.YYYY, HH:mm',
                    ],
                ])
                ->add('categories', null, [], [
                    'allow_add' => true
                ])
            ->end()
            ->with('Pictures', [
                'class' => 'col-md-6'
            ])
                ->add('description', TextareaType::class)
                ->add('picture', 'sonata_media_type', [
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'default'
                ])
            ->end()
            ->with('Content')
                ->add('content', 'sonata_simple_formatter_type', [
                    'format' => 'richhtml',
                    'ckeditor_context' => 'default',
                ])
                ->add('recipes', 'sonata_type_collection', [
                    'by_reference' => false
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                ])
            ->end()
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