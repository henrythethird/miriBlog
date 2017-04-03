<?php

namespace AppBundle\Service;

use AppBundle\Entity\Post;
use JonnyW\PhantomJs\Client;
use JonnyW\PhantomJs\Http\PdfRequest;
use PhantomInstaller\PhantomBinary;
use Symfony\Component\Routing\Router;

class PDFService
{
    /**
     * @param string $url
     * @param string $outputFile
     * @param bool $overwrite
     * @return void
     */
    public function generate($url, $outputFile, $overwrite = false)
    {
        if (!$overwrite && file_exists($outputFile)) {
            return;
        }

        $client = Client::getInstance();
        $client->getEngine()->setPath(PhantomBinary::getBin());

        $request = $this->createParametrizedRequest($url, $outputFile, $client);

        $response = $client->getMessageFactory()->createResponse();
        $client->send($request, $response);

        if ($response->getStatus() != 200) {
            dump($request, $response);
            throw new \RuntimeException("PDF could not be generated");
        }
    }

    /**
     * @param string $url
     * @param string $outputFile
     * @param Client $client
     * @return PdfRequest
     */
    private function createParametrizedRequest($url, $outputFile, Client $client)
    {
        $request = $client->getMessageFactory()->createPdfRequest($url);

        $request->setOutputFile($outputFile);
        $request->setFormat('A4');
        $request->setOrientation('portrait');
        $request->setMargin('1cm');
        $request->setCaptureDimensions(720, 0);
        $request->setTimeout(15000);

        return $request;
    }
}