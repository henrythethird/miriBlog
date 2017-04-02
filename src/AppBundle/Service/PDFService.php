<?php

namespace AppBundle\Service;

use AppBundle\Entity\Post;
use JonnyW\PhantomJs\Client;
use PhantomInstaller\PhantomBinary;
use Symfony\Component\Routing\Router;

class PDFService
{
    public function generate($url, $outputFile, $overwrite = false)
    {
        if (!$overwrite && file_exists($outputFile)) {
            return $outputFile;
        }

        $client = Client::getInstance();
        $client->getEngine()->setPath(PhantomBinary::getBin());

        $request = $client->getMessageFactory()->createPdfRequest($url);

        $request->setOutputFile($outputFile);
        $request->setFormat('A4');
        $request->setOrientation('portrait');
        $request->setMargin('1cm');
        $request->setCaptureDimensions(720, 0);

        $response = $client->getMessageFactory()->createResponse();
        $client->send($request, $response);

        if ($response->getStatus() != 200) {
            throw new \RuntimeException("PDF could not be generated");
        }
    }
}