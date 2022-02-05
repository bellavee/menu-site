<?php

require_once("model/Food.php");

class FoodBuilder {

    protected $data;
    protected $errors;
    protected $file;
    protected $filename;

    public function __construct($data, $file) {
        $this->data = $data;
        $this->errors = array();
        $this->file = $file;
    }

    public static function buildFromFood(array $food) {
        $file = array("file" => array("name" => $food["image"], "tmp_name" => $food["image"]));

        return new FoodBuilder(array(
            "name" => $food["name"],
            "description" => $food["description"], 
            "type" => $food["type"],
            "origin" => $food["origin"],
        ), $file);
    }

    public function getData($ref) {
        return key_exists($ref, $this->data) ? $this->data[$ref] : '';
    } 

    public function getFile() {
        return $this->file["file"]["name"];
    }

    public function isValid() {
        $this->errors = array();
    
        if (!key_exists("name", $this->data) || $this->data["name"] === "")
			$this->errors["name"] = "Vous devez entrer un nom";
		
        else if (mb_strlen($this->data["name"], 'UTF-8') >= 30)
			$this->errors["name"] = "Le nom doit faire moins de 30 caractères";
        
        if (!key_exists("description", $this->data) || $this->data["description"] === "")
			$this->errors["description"] = "Vous devez entrer un description";

        if (!key_exists("type", $this->data) || $this->data["type"] === "")
			$this->errors["type"] = "Vous devez entrer un type";
		
        if (!key_exists("origin", $this->data) || $this->data["origin"] === "")
			$this->errors["origin"] = "Vous devez entrer une origine";
                    
        $extension = pathinfo($this->file['file']['name'], PATHINFO_EXTENSION);

        if (($extension != 'jpg' && $extension != 'png' && $extension != 'jpeg' && $extension != 'gif') || ($this->file['file']['size'] == 0)) {
            $this->errors["file"] = "Obligatoire. Extensions autorisées : jpg, jpeg, png, gif. La taille de l'image doit être inférieure à 1Mb";
        }

        return count($this->errors) === 0;
    }

    public function getErrors($ref) {
		return key_exists($ref, $this->errors) ? $this->errors[$ref] : null;
	}

    public function createFood($account) {
        $this->file['file']['name'] = str_replace(' ', '', $this->file['file']['name']);
        $this->filename = uniqid().$this->file['file']['name'];
        
        if ($this->file['file']['tmp_name'] == $this->file['file']['name']) 
            $this->filename = $this->file['file']['name'];
        else 
            move_uploaded_file($this->file['file']['tmp_name'], 'src/upload/' . $this->filename);

        return new Food($this->data["name"], $this->data["description"], $this->data["type"], $this->data["origin"], $this->filename, $account);
    }


}

?>