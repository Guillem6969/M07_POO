<?php namespace ComBank\Person;

      use ComBank\Support\Traits\ApiTrait;

class Person {

    use ApiTrait;
    private $email;

    private $idCard;

    private $name;

    private $phone;
    
    function __construct(string $email = null, $idCard, $name, string $phone = null) {
        $this->idCard = $idCard;
        $this->name = $name;

        if( $email === null ){
            $this->email = "john.doe@example.com";
        } else{
            if ($this->validateEmail($email)){
                $this->email = $email;
                pl("validating email: ".$email);
                pl("Email is valid");
            } else{
                pl("validating email: ".$email);
                pl("Error: invalid email address: ". $email);
            }
        }
    
        if( $phone === null ){
            $this->phone = "+34607600775";
        } else {
            if ($this->validatePhone($phone)){
                $this->phone = $phone;
                pl("Validating phone: ".$phone);
                pl("Phone is valid");
            } else{
                pl("Validating email: ".$phone);
                pl("Phone: invalid phone number: ". $phone);
            }
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

