<?php

namespace AppBundle\Form;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IconType extends AbstractType
{
    private $categoryPath;
    private $categoryOffset;

    public function __construct($webPath, $categoryOffset)
    {
        $this->categoryPath = sprintf("%s%s", $webPath, $categoryOffset);
        $this->categoryOffset = $categoryOffset;
    }

    private function findIcons()
    {
        $finder = new Finder();

        $files = [];
        foreach ($finder->in($this->categoryPath) as $file) {
            $files[] = sprintf("%s/%s", $this->categoryOffset, $file->getRelativePathname());
        }
        return $files;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $paths = $this->findIcons();
        $resolver->setDefaults([
            'choices' => array_combine($paths, $paths)
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}