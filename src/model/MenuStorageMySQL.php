<?php

require_once("model/Food.php");
require_once("model/MenuStorage.php");

class MenuStorageMySQL implements MenuStorage {
    private $pdo;

    public function __construct($MYSQL_DSN, $MYSQL_USER, $MYSQL_PASSWORD) {
        $this->pdo = new PDO($MYSQL_DSN, $MYSQL_USER, $MYSQL_PASSWORD);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function create(Food $food) {
        $getId = $this->pdo->query('SELECT max(id) FROM menu')->fetch();
        $id = $getId['max(id)'] + 1;
        $name = $food->getName();
        $description = $food->getDescription();
        $type = $food->getType();
        $origin = $food->getOrigin();
        $image = $food->getImage();
        $account = $food->getAccount();

        $sql = "INSERT INTO menu(id, name, description, type, origin, image, account) VALUES (:id, :name, :description, :type, :origin, :image, :account)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'name' => $name, 'description' => $description, 'type' => $type, 'origin'=> $origin, 'image' => $image, 'account' => $account]);

        return $id;
    }

    public function read($id) {
        $sql = "SELECT * FROM menu WHERE id = '$id'";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch();
    }

    public function readAll() {
        $sql = 'SELECT * FROM menu';
        $stmt =  $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function delete($id) {
        $sql = "DELETE FROM menu WHERE id = :id;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function random() {
        $sql = "SELECT * FROM menu ORDER BY RAND() LIMIT 1";
        $stmt =  $this->pdo->query($sql);
        return $stmt->fetch();
    }

    public function update($id, Food $food) {
        $name = $food->getName();
        $description = $food->getDescription();
        $type = $food->getType();
        $origin = $food->getOrigin();
        $image = $food->getImage();
        $account = $food->getAccount();

        $sql = "UPDATE menu SET name = :name, description = :description, type = :type, origin = :origin, image = :image, account = :account WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'name' => $name, 'description' => $description, 'type' => $type, 'origin'=> $origin, 'image' => $image, 'account' => $account]);

        return $id;
    }

}

?>