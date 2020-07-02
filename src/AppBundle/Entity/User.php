<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Task;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table("user")
 * @ORM\Entity
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 * @UniqueEntity("password")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur.")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $roles = 'ROLE_USER';

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir une adresse email.")
     * @Assert\Email(message="Le format de l'adresse n'est pas correcte.")
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Task", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $tasks;

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): string
    {
        return $this->roles;
    }

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function eraseCredentials()
    {
    }

    public function __construct() 
    { 
        $this->tasks = new ArrayCollection(); 
    }

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->getRoles() == 'ROLE_ADMIN';
    }

    /**
     * @return boolean
     */
    public function isAnon()
    {
        if ($this->username == 'Anonyme') {
            return true;
        }
        return false;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setUser($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            if ($task->getUser() === $this) {
                $task->setUser(null);
            }
        }

        return $this;
    }

    // public static function getAuthorizedRoles()
    // {
    //     return [['ROLE_USER'], ['ROLE_ADMIN']];
    // }
}
