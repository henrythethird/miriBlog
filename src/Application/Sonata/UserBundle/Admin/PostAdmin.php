<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostAdmin extends Admin {
	protected function configureFormFields(FormMapper $form) {
		$form
			->add('title', TextType::class)
			->add('description', TextareaType::class)
			->add('content', TextareaType::class)
			->add('category', ChoiceType::class)
		;
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper->add('title');
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper->addIdentifier('title');
	}
}