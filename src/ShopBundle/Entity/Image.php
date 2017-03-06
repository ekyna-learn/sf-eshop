<?php

namespace ShopBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 */
class Image
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $alt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var UploadedFile
     */
    private $upload;


    /**
     * Get the string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getAlt();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set product
     *
     * @param Product $product
     *
     * @return Image
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return Image
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Sets the updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Image
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Returns the updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Sets the upload.
     *
     * @param UploadedFile $upload
     *
     * @return Image
     */
    public function setUpload(UploadedFile $upload)
    {
        $this->upload = $upload;

        $this->setUpdatedAt(new \DateTime());

        return $this;
    }

    /**
     * Returns the upload.
     *
     * @return UploadedFile
     */
    public function getUpload()
    {
        return $this->upload;
    }
}

