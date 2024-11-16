<?php namespace ComBank\Person;

      use ComBank\Support\Traits\ApiTrait;

class Person {

    use ApiTrait;
    private $email;

    private $idCard;

    private $name;

    
    function __construct($email, $idCard, $name) {
        $this->idCard = $idCard;
        $this->name = $name;

        if ($this->validateEmail($email)){
            $this->email = $email;
            pl("validating email: ".$email);
            pl("Email is valid");
        } else{
            pl("validating email: ".$email);
            pl("Error: invalid email address: ". $email);
        }
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
