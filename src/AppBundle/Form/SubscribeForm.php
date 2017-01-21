<?php

namespace AppBundle\Form;

use AppBundle\Entity\Subscribe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscribeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder->add('email', EmailType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
		$resolver->setDefaults([
			'data_class' => Subscribe::class
		]);
    }

    public function getName()
    {
        return 'app_bundle_subscribe_form';
    }
}
