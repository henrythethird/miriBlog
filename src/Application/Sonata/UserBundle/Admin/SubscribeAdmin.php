<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class SubscribeAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form) {
        $form
            ->add('email', EmailType::class)
            ->add('active')
            ->add('date_created', 'sonata_type_datetime_picker', [
                'required' => false,
                'disabled' => true,
                'read_only' => true,
                'format' => 'dd.MM.yyyy, HH:mm',
                'attr' => [
                    'data-date-format' => 'DD.MM.YYYY, HH:mm',
                ],
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->addIdentifier('active')
            ->addIdentifier('date_created')
        ;
    }
}