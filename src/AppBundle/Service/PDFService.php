<?php

namespace AppBundle\Service;

use AppBundle\Entity\Post;
use JonnyW\PhantomJs\Client;
use PhantomInstaller\PhantomBinary;
use Symfony\Component\Routing\Router;

class PDFService
{
    private $pdfPath;
    private $router;
    private $baseUrl;

    public function __construct($pdfPath, $baseUrl, Router $router)
    {
        $this->pdfPath = $pdfPath;
        $this->baseUrl = $baseUrl;
        $this->router = $router;
    }

    public function generate(Post $post, $overwrite = false)
    {
        $outputFile = sprintf("%s/%s.pdf", $this->pdfPath, $post->getSlug());
        if (!$overwrite && file_exists($outputFile)) {
            return $outputFile;
        }

        $client = Client::getInstance();
        $client->getEngine()->setPath(PhantomBinary::getBin());

        $request = $client->getMessageFactory()->createPdfRequest(
            $this->generateUrl($post)
        );

        $request->setOutputFile($outputFile);
        $request->setFormat('A4');
        $request->setOrientation('portrait');
        $request->setMargin('1cm');
        $request->setCaptureDimensions(720, 0);
        $request->setTimeout(15000);

        $response = $client->getMessageFactory()->createResponse();
        $client->send($request, $response);

        if ($response->getStatus() != 200) {
            throw new \RuntimeException("PDF could not be generated");
        }

        return $outputFile;
    }

    /**
     * @param Post $post
     * @return string
     */
    private function generateUrl(Post $post)
    {
        return sprintf("%s%s", $this->baseUrl,
            $this->router->generate('print_view_post', [
                'slug' => $post->getSlug()
            ], Router::ABSOLUTE_PATH)
        );
    }
}