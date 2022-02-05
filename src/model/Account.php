<?php

class Account {
    protected $yourname;
    protected $username;
    protected $password;
    protected $status;

    public function __construct($yourname='', $username='', $password='', $status=null) {
        $this->yourname = $yourname;
        $this->username = $username;
        $this->password = $password;
        $this->status = $status;
    }

    public function getYourName() {
        return $this->yourname;
    }

    public function getUserName() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getStatus() {
        return $this->status;
    }

}

?>