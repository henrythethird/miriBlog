<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class StepAdmin extends AbstractAdmin {
	protected function configureFormFields(FormMapper $form) {
		$form
			->add('description')
			->add('hint', null, [
				'required' => false
			])
			->add('invert_hint')
            ->add('separatorAbove')
			->add('position', 'hidden')
		;
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('description');
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->addIdentifier('description');
	}
}