<?php

namespace ShopBundle\Service\User;

use ShopBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserManager
 * @package ShopBundle\Service\User
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class UserManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;


    /**
     * Constructor.
     *
     * @param EntityManagerInterface       $em
     * @param ValidatorInterface           $validator
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->em = $em;
        $this->validator = $validator;
        $this->encoder = $encoder;
    }

    /**
     * Creates a new user.
     *
     * @param string $username
     * @param string $password
     * @param array  $roles
     *
     * @throws \InvalidArgumentException
     *
     * @return User
     */
    public function createUser($username, $password, array $roles)
    {
        if (4 > strlen($password)) {
            throw new \InvalidArgumentException('Password is too short.');
        }

        // Create the user
        $user = new User();
        $user
            ->setUsername($username)
            ->setRoles($roles);

        // Validate the user
        $errors = $this->validator->validate($user);
        if (0 < count($errors)) {
            throw new \InvalidArgumentException((string)$errors);
        }

        // Encode and set password
        $encoded = $this->encoder->encodePassword($user, $password);
        $user->setPassword($encoded);

        // Persist the user
        $this->em->persist($user);
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        $this->em->flush($user);

        return $user;
    }
}
