<?php

namespace AppBundle\Entity;

interface DownloadableInterface
{
    public function getId();
    public function getPdfFile();
    public function setPdfFile(PdfFile $file);
}