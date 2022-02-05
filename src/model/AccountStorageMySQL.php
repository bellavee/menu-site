<?php

require_once("model/Account.php");
require_once("model/AccountStorage.php");

class AccountStorageMySQL implements AccountStorage {

    private $pdo;

    public function __construct($MYSQL_DSN, $MYSQL_USER, $MYSQL_PASSWORD) {
        $this->pdo = new PDO($MYSQL_DSN, $MYSQL_USER, $MYSQL_PASSWORD);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function checkAuth($username, $password) {
        $sql = "SELECT * FROM account WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $account = $stmt->fetch();

        if ($account != null) {
            if (password_verify($password, $account['password'])) {
                return new Account($account['yourname'], $account['username'], $account['password'], $account['status']);
            } else 
                return null;
        }

        else 
            return null;
    }

    public function readUser($username) {
        $sql = "SELECT * FROM account WHERE username = '$username'";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch();
    }

    public function read($id) {
        $sql = "SELECT * FROM account WHERE id = '$id'";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch();
    }

    public function createAccount($data) {
        $getId = $this->pdo->query('SELECT max(id) FROM account')->fetch();
        $id = $getId['max(id)'] + 1;
        $yourname = $data['yourname'];
        $username = $data['usernameSignUp'];
        $password = password_hash($data['passwordSignUp'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO account(id, yourname, username, password) VALUES (:id, :yourname, :username, :password)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'yourname' => $yourname, 'username' => $username, 'password' => $password]);
    }

    public function createAdmin() {
        $getId = $this->pdo->query('SELECT max(id) FROM account')->fetch();
        $id = $getId['max(id)'] + 1;
        $yourname = "Administrateur";
        $username = "admin";
        $password = password_hash("toto", PASSWORD_BCRYPT);
        $status = "admin";

        $sql = "INSERT INTO account(id, yourname, username, password, status) VALUES (:id, :yourname, :username, :password, :status)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'yourname' => $yourname, 'username' => $username, 'password' => $password, 'status' => $status]);
    }

    public function readAll() {
        $sql = 'SELECT * FROM account';
        $stmt =  $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function delete($id) {
        $sql = "DELETE FROM account WHERE id = :id;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    

}

?>