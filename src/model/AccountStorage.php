<?php

interface AccountStorage {
    
    public function checkAuth($username, $password);

    public function createAccount($data);

    public function readUser($username);

    public function createAdmin();

    public function readAll();

    public function read($id);

    public function delete($id);

}

?>