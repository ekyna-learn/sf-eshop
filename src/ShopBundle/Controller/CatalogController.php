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
     * Catalog category action.
     *
     * @param string $categorySlug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryAction($categorySlug)
    {
        $category = $this->findCategoryBySlug($categorySlug);

        return new Response('Category: ' . $category->getTitle());
    }

    /**
     * Catalog product action.
     *
     * @param string $categorySlug
     * @param string $productSlug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productAction($categorySlug, $productSlug)
    {
        $category = $this->findCategoryBySlug($categorySlug);

        $product = $this
            ->getDoctrine()
            ->getRepository('ShopBundle:Product')
            ->findOneByCategoryAndSlug($category, $productSlug);

        if (null === $product) {
            throw $this->createNotFoundException('Product not found.');
        }

        return new Response('Category: ' . $category->getTitle() . '<br>Product: ' . $product->getTitle());
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

    /**
     * Finds the category by slug.
     *
     * @param string $slug
     *
     * @return \ShopBundle\Entity\Category|null
     */
    private function findCategoryBySlug($slug)
    {
        $category = $this
            ->getDoctrine()
            ->getRepository('ShopBundle:Category')
            ->findEnabledBySlug($slug);

        if (null === $category) {
            throw $this->createNotFoundException('Category not found.');
        }

        return $category;
    }
}
