<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IconType extends AbstractType
{
    const CHOICE_MAP = [
        'images/categories/5_a_day.png',
        'images/categories/about.png',
        'images/categories/alcohol.png',
        'images/categories/all.png',
        'images/categories/archive.png',
        'images/categories/baked.png',
        'images/categories/bread.jpg',
        'images/categories/breakfast.png',
        'images/categories/carbs.png',
        'images/categories/dessert.png',
        'images/categories/drinks.jpg',
        'images/categories/fish.png',
        'images/categories/handmade.png',
        'images/categories/hauptgang.jpg',
        'images/categories/high_protein.png',
        'images/categories/home.png',
        'images/categories/icons8.png',
        'images/categories/ingredients.png',
        'images/categories/lowcarb.png',
        'images/categories/meat.png',
        'images/categories/no_alcohol.png',
        'images/categories/no_gluten.png',
        'images/categories/no_milk.png',
        'images/categories/no_sugar.png',
        'images/categories/pdf.png',
        'images/categories/pizza.jpg',
        'images/categories/salad.png',
        'images/categories/scharfes.jpg',
        'images/categories/smoothie.jpg',
        'images/categories/snack.png',
        'images/categories/sosse.png',
        'images/categories/soup.png',
        'images/categories/vegan.png',
        'images/categories/vegetarian.png',
    ];

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => array_combine(self::CHOICE_MAP, self::CHOICE_MAP)
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}