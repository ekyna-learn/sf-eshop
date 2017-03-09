<?php

namespace ShopBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package ShopBundle\Entity
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var bool
     */
    private $isActive;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->isActive = true;

        // not needed with bcrypt encoder
        // see http://symfony.com/doc/current/security/entity_provider.html#creating-your-first-user
        // $this->salt = md5(uniqid(null, true));
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set roles
     *
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Get roles
     *
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = (bool) $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @inheritdoc
     */
    public function getSalt()
    {
        // not needed with bcrypt encoder
        // see http://symfony.com/doc/current/security/entity_provider.html#creating-your-first-user
        return null;
    }


    /**
     * @inheritdoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * Serialize user
     *
     * @see \Serializable::serialize()
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see http://symfony.com/doc/current/security/entity_provider.html#creating-your-first-user
            // $this->salt,
        ));
    }

    /**
     * Unserialize user
     *
     * @see \Serializable::unserialize()
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see http://symfony.com/doc/current/security/entity_provider.html#creating-your-first-user
            // $this->salt
        ) = unserialize($serialized);
    }
}
