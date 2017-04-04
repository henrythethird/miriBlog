<?php

namespace AppBundle\Entity;

interface SeparatableInterface
{
    public function hasSeparatorAbove();
    public function setSeparatorAbove($separatorAbove);
}