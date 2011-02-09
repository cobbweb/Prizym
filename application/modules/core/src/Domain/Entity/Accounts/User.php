<?php

namespace Application\Core\Domain\Entity\Accounts;

/**
 * Description of User
 *
 * @author Andrew Cobby <cobby@cobbweb.me>
 * 
 * @MappedSuperclass
 */
class User
{

    /**
     * @Id @GeneratedValue
     * @Column(type="integer")
     * 
     * @var integer
     */
    private $id;
    /**
     * @Column(type="string", nullable=true)
     *
     * @var string
     */
    private $firstName;
    /**
     * @Column(type="string", nullable=true)
     *
     * @var string 
     */
    private $lastName;
    /**
     * @Column(type="string")
     *
     * @var string
     */
    private $email;
    /**
     * @Column(type="string")
     *
     * @var string
     */
    private $password;

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

}

