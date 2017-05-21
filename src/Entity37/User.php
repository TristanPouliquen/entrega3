<?php
namespace Entity37;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="guloja_user")
 */
Class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="guloja_user_id_seq", allocationSize=100, initialValue=1)
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $email;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    protected $plainPassword;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $salt;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $roles;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;
    /**
     * __construct
     *
     * @return User $this
     */
    public function __construct() {
        return $this;
    }
    /**
     * displayName
     *
     * @return string a displayable name
     */
    public function displayName()
    {
        return sprintf("%s", $this->getUserName());
    }
    /**
     * Returns the email address, which serves as the username used to authenticate the user.
     *
     * This method is required by the UserInterface.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getEmail();
    }
    /**
     * Removes sensitive data from the user.
     *
     * This is a no-op, since we never store the plain text credentials in this object.
     * It's required by UserInterface.
     *
     * @return void
     */
    public function eraseCredentials()
    {
        $this->plainPassword = "";
    }
    public function setEncodedPassword($container)
    {
        $this->setPassword($container['security.encoder.digest']
            ->encodePassword($this->getPlainPassword(), $this->getSalt()));
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
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set password
     *
     * @param string $password
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
     * Set plainPassword
     *
     * @param string $password
     * @return User
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
        return $this;
    }
    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }
    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }
    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
        return $this;
    }
    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
        return $this;
    }
    /**
     * Get updated_at
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    /**
     * Set roles
     *
     * @param string $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }
    /**
     * Get roles
     *
     * @return string
     */
    public function getRoles()
    {
        return array($this->roles);
    }
}
