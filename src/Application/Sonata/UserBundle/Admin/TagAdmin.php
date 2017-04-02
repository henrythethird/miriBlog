<?php

namespace Application\Sonata\UserBundle\Admin;

use AppBundle\Form\IconType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TagAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form) {
        $form
            ->add('name')
            ->add('icon', IconType::class, [
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'required' => false
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('icon')
            ->add('description')
        ;
    }
}