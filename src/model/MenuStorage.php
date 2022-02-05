<?php

interface MenuStorage {

    public function create(Food $menu);
    
    public function read($id);

    public function readAll();

    public function delete($id);

    public function random();

    public function update($id, Food $food);

}

?>