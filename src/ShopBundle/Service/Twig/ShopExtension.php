<?php

namespace ShopBundle\Service\Twig;

use ShopBundle\Entity\Image;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class ShopExtension
 * @package ShopBundle\Service\Twig
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class ShopExtension extends \Twig_Extension
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;


    /**
     * Constructor.
     *
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('image_path', [$this, 'getImagePath']),
        ];
    }

    /**
     * Returns the image path.
     *
     * @param Image $image
     *
     * @return string
     */
    public function getImagePath(Image $image)
    {
        return $this->urlGenerator->generate('shop_catalog_image', [
            'imageId' => $image->getId(),
        ], UrlGeneratorInterface::ABSOLUTE_PATH);
    }
}
