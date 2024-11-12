<?php namespace ComBank\Person;

class Person {
    private $email;

    private $idCard;

    private $name;

    
    function __construct($email, $idCard, $name) {
        $this->email = $email;
        $this->idCard = $idCard;
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIdCard()
    {
        return $this->idCard;
    }

    /**
     * Set the value of idCard
     */
    public function setIdCard($idCard): self
    {
        $this->idCard = $idCard;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }
}

