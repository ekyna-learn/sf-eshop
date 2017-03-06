<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CatalogController
 * @package ShopBundle\Controller
 */
class CatalogController extends Controller
{
    /**
     * Catalog index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('ShopBundle:Catalog:index.html.twig');
    }

    /**
     * Catalog image action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function imageAction(Request $request)
    {
        /** @var \ShopBundle\Entity\Image $image */
        $image = $this
            ->getDoctrine()
            ->getRepository('ShopBundle:Image')
            ->find($request->attributes->get('imageId'));

        if (null === $image) {
            throw $this->createNotFoundException('Image not found');
        }

        $response = new Response();
        $response->setLastModified($image->getUpdatedAt());
        if ($response->isNotModified($request)) {
            return $response;
        }

        $uploader = $this->get('shop.upload.image_uploader');
        if (null === $file = $uploader->loadFile($image->getFile())) {
            throw $this->createNotFoundException('File not found');
        }

        $response = new BinaryFileResponse($file);
        $response->setLastModified($image->getUpdatedAt());

        return $response;
    }
}
