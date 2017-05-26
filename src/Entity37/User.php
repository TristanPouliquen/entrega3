<?php
namespace Entity37;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="guloja_user")
 * @UniqueEntity(fields="username", message="Email already taken")
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
     * @ORM\Column(type="string", length=255, name="email")
     * @Assert\Email(
     *  message="Email not valid",
     *  checkHost = true
     * )
     */
    protected $username;
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
     * @ORM\Column(type="array", length=255)
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
        $this->roles = ["ROLE_USER"];
        return $this;
    }

    public function __toString(){
        return $this->email;
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
        $this->setPassword($container['security.encoder_factory']->getEncoder($this)
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
     * Set username
     *
     * @param string $username
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
        // HACK : seems the password was loading with a trailing whitespace, which caused login failure
        return trim($this->password);
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
     * @param array $roles
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
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
