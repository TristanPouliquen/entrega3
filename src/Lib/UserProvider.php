<?php

namespace Lib;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

use Doctrine\ORM\EntityManager;

use Silex\Application;

class UserProvider implements UserProviderInterface
{
  private $app;

  public function __construct(Application $app)
  {
    $this->app = $app;
  }

  public function loadUserByUsername($username)
  {
    $em = $this->app['orm.ems']['grupo37'];
    if($em instanceof EntityManager){
      if(!$user = $em->getRepository("Entity37\User")->findOneBy(array("username"=>$username))){
        throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
      }
    }
    return $user;
  }

  public function refreshUser(UserInterface $user)
  {
    if (!$user instanceof \Entity37\User) {
      throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
    }
    return $this->loadUserByUsername($user->getUsername());
  }

  public function supportsClass($class)
  {
    return $class === '\Entity37\User';
  }

  /**
     * Get the password encoder to use for the given user object.
     *
     * @param UserInterface $user
     * @return PasswordEncoderInterface
     */
    protected function getEncoder(UserInterface $user)
    {
        return $this->app['security.encoder_factory']->getEncoder($user);
    }
    /**
     * Encode a plain text password for a given user. Hashes the password with the given user's salt.
     *
     * @param \Entity37\User $user
     * @param string $password A plain text password.
     * @return string An encoded password.
     */
    public function encodeUserPassword(\Entity37\User $user, $password)
    {
        $encoder = $this->getEncoder($user);
        return $encoder->encodePassword($password, $user->getSalt());
    }
    /**
     * Encode a plain text password and set it on the given User object.
     *
     * @param \Entity37\User $user
     * @param string $password A plain text password.
     */
    public function setUserPassword(\Entity37\User $user, $password)
    {
        return $user->setPassword($this->encodeUserPassword($user, $password));
    }
    /**
     * Test whether a given plain text password matches a given User's encoded password.
     *
     * @param \Entity37\User $user
     * @param string $password
     * @return bool
     */
    public function checkUserPassword(\Entity37\User $user, $password)
    {
        return $user->getPassword() === $this->encodeUserPassword($user, $password);
    }
    /**
     * Get a User instance for the currently logged in User, if any.
     *
     * @return UserInterface|null
     */
    public function getCurrentUser()
    {
        if ($this->isLoggedIn()) {
            return $this->app['security.token_storage']->getToken()->getUser();
        }
        return null;
    }
    /**
     * Test whether the current user is authenticated.
     *
     * @return boolean
     */
    function isLoggedIn()
    {
        $token = $this->app['security.token_storage']->getToken();
        if (null === $token) {
            return false;
        }
        return $this->app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_REMEMBERED');
    }

}
