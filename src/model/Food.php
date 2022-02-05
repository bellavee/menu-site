<?php

class Food {

    protected $name;
    protected $description;
    protected $type;
    protected $origin; 
    protected $image;
    protected $account;

    public function __construct($name, $description, $type, $origin, $image, $account) {
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
        $this->origin = $origin;
        $this->image = $image;
        $this->account = $account;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getType() {
        return $this->type;
    }
    
    public function getOrigin() {
        return $this->origin;
    }
    
    public function getImage() {
        return $this->image;
    }

    public function getAccount() {
        return $this->account;
    }
}

?>