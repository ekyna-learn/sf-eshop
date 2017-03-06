<?php

namespace ShopBundle\Entity;

use Behat\Transliterator\Transliterator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Product
 */
class Product
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Seo
     */
    private $seo;

    /**
     * @var Category
     */
    private $category;

    /**
     * @var ArrayCollection
     */
    private $images;

    /**
     * @var ArrayCollection
     */
    private $features;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var float
     */
    private $price;

    /**
     * @var int
     */
    private $stock;

    /**
     * @var \DateTime
     */
    private $releasedAt;

    /**
     * @var string
     */
    private $slug;


    /**
     * Constructor.
     */
    public function __construct()
    {
        // OneToOne could be considered like : "Every Product has its own Seo".
        // This is like embedding, so we create the Seo instance for convenience.
        $this->seo = new Seo();
        // When Doctrine will load products which already have Seo data, he will
        // simply override the instance we just created.

        // We MUST initialize the Collections for OneToMany and ManyToMany associations.
        // One product has Many images
        $this->images = new ArrayCollection();
        // Many products has Many features
        $this->features = new ArrayCollection();
    }

    /**
     * Get the string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
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
     * Set seo
     *
     * @param Seo $seo
     *
     * @return Product
     */
    public function setSeo(Seo $seo)
    {
        $this->seo = $seo;

        return $this;
    }

    /**
     * Get seo
     *
     * @return Seo
     */
    public function getSeo()
    {
        return $this->seo;
    }

    /**
     * Set category
     *
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add image
     *
     * @param Image $image
     *
     * @return Product
     */
    public function addImage(Image $image)
    {
        // If the given image (method argument) is NOT already associated.
        if (!$this->images->contains($image)) {
            // Inverse side [Product] : Add the image to the collection.
            $this->images->add($image);
            // Owner (proprietary) side [Image] : Set the product so that.
            // Doctrine (and the database) can assign the foreign key (table's "product_id" column).
            $image->setProduct($this);
        }

        return $this;
    }

    /**
     * Remove image
     *
     * @param Image $image
     *
     * @return Product
     */
    public function removeImage(Image $image)
    {
        // If the given image is associated (i.e. equals to an image in our collection).
        if ($this->images->contains($image)) {
            // Inverse side : Remove the image from the collection.
            $this->images->removeElement($image);
            // Owner side (proprietary) : Unset the association.
            $image->setProduct(null);
            // If you check set Image::setProduct() method, you'll see that it allows null value,
            // even if the mapping does not allow it (joinColumn could have the option nullable=false).

            // In the src/ShopBundle/Resources/config/doctrine/Product.orm.yml file on line 49,
            // you'll see that the "orphanRemoval" option is set to "true". Doctrine will schedule a
            // remove on all the images that are no longer referenced in a product, then we don't need
            // to call EntityManager::remove($image) ourselves.
        }

        return $this;
    }

    /**
     * Get images
     *
     * @return ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add feature
     *
     * @param Feature $feature
     *
     * @return Product
     */
    public function addFeature(Feature $feature)
    {
        // ManyToMany : This is a bit special, we could get ride of the owner/inverse sides concept.

        // If the given feature is not already associated
        if (!$this->features->contains($feature)) {
            // Add the feature to the product
            // (we could consider that this is the owner side, as our application
            //  is designed to add features to products and not the inverse).
            $this->features->add($feature);
            // Add the product to the feature (could be considered as the inverse side).
            $feature->addProduct($this);

            // Now if you check the Feature::addProduct method, you'll see that it calls
            // the Product::addFeature() method too. But the test on line 222 (of this file) will fail
            // (feature has already been added to the Product::features collection field).
            // The above code will not be executed twice : infinite loop is prevented, and both sides
            // of the association are instantly synchronized.
        }

        return $this;
    }

    /**
     * Remove feature
     *
     * @param Feature $feature
     *
     * @return Product
     */
    public function removeFeature(Feature $feature)
    {
        // Same as addFeature : we synchronize both sides of the association
        // and prevent infinite loop.
        if ($this->features->contains($feature)) {
            $this->features->removeElement($feature);
            $feature->removeProduct($this);
        }

        return $this;
    }

    /**
     * Get features
     *
     * @return ArrayCollection|Feature[]
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set stock
     *
     * @param int $stock
     *
     * @return Product
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set releasedAt
     *
     * @param \DateTime $releasedAt
     *
     * @return Product
     */
    public function setReleasedAt(\DateTime $releasedAt)
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    /**
     * Get releasedAt
     *
     * @return \DateTime
     */
    public function getReleasedAt()
    {
        return $this->releasedAt;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Pre persist (create only) event callback.
     *
     * Called by doctrine: see lifecycleCallbacks in the mapping file.
     * @see src/ShopBundle/Resources/config/doctrine/Product.orm.yml
     */
    public function onPrePersist()
    {
        $this->updateSlug();
    }

    /**
     * Pre update event callback.
     *
     * Called by doctrine: see lifecycleCallbacks in the mapping file.
     * @see src/ShopBundle/Resources/config/doctrine/Product.orm.yml
     *
     * @param PreUpdateEventArgs $event
     */
    public function onPreUpdate(PreUpdateEventArgs $event)
    {
        // The PreUpdateEventArgs allow us to track if some properties has been changed
        if ($event->hasChangedField('title')) {
            $this->updateSlug();
        }
    }

    /**
     * Updates the slug from the title.
     */
    private function updateSlug()
    {
        // Turns 'This is a great product' into 'this-is-a-great-product'
        $slug = Transliterator::urlize($this->getTitle());

        $this->setSlug($slug);
    }
}

