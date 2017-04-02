<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class PrintController extends Controller
{
    /**
     * @Route("/print/post/view/{slug}", name="print_view_post")
     * @Template("print/post.html.twig")
     */
    public function printPostAction(Post $post)
    {
        return [
            'post' => $post,
            'enableLinks' => false
        ];
    }

    /**
     * @Route("/print/post/pdf/{slug}", name="print_post")
     */
    public function printPostPDFAction(Post $post)
    {
        $response = new BinaryFileResponse(
            $this->get('app_bundle.pdf')->generate($post)
        );
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;
    }
}