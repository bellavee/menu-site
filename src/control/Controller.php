<?php

require_once("view/View.php");
require_once("model/Food.php");
require_once("model/FoodBuilder.php");
require_once("model/MenuStorage.php");
require_once("model/AccountStorage.php");

class Controller {
    protected $view;
    protected $menu_db;
    protected $account_db;

	public function __construct(View $view, MenuStorage $menu_db, AccountStorage $account_db) {
		$this->view = $view;
        $this->menu_db = $menu_db;
        $this->account_db = $account_db;
	}

    public function showHomePage($yourname) {
        $all = $this->menu_db->readAll();
        if ($all == null) {
            $this->view->makeHome($yourname);
        } else {
            $food = $this->menu_db->random();
            $this->view->makeHomePage($food, $yourname);
        }
    }

    public function showInformation($id, $account) {
        $food = $this->menu_db->read($id);
        if ($food != null) {
            $this->view->makeFoodPage($id, $food, $account);
        } else {
            $this->view->makeUnknownPage();
        }
    }

    public function showGallery() {
        $menu = $this->menu_db->readAll();
        $this->view->makeGalleryPage($menu);
    }

    public function newFood() {
        $food = new FoodBuilder(array(), array("file" => array("name" => "")));
        $this->view->makeCreationPage($food);
    }

    public function saveNewFood($data, $file, $account) {
        $builder = new FoodBuilder($data, $file);
        if ($builder->isValid()) {
            $food = $builder->createFood($account);
            $foodId = $this->menu_db->create($food);
            $this->view->displayCreationSuccess($foodId);
        } else {
            $this->view->makeCreationPage($builder);
        }
    }

    public function askDeletion($id) {
        $food = $this->menu_db->read($id);

        if ($food != null) {
            $this->view->makeDeletionPage($id, $food);
        } else {
            $this->view->makeUnknownPage();
        }
    }

    public function confirmDeletion($id) {
        $food = $this->menu_db->read($id);
        if ($food['image'] != null) 
            unlink('src/upload/' . $food['image']);
        
        $delete = $this->menu_db->delete($id);
        
        if (!$delete) {
            $this->view->makeUnknownPage();
        } else {
            $this->view->makeDeletedPage();
        }
    }

    public function modifyFood($id) {
        $food = $this->menu_db->read($id);
        if ($food == null) 
            $this->view->makeUnknownPage();
        else {
            $builder = FoodBuilder::buildFromFood($food);
            $this->view->makeModificationPage($id, $builder);
        }
    }

    public function saveModified($id, $data, $file, $account) {
        $food = $this->menu_db->read($id);

        /* upload image */
        if ($file['file']['name'] !== '') {
            unlink('src/upload/' . $food['image']);
            $builder = new FoodBuilder($data, $file);
        } 
        
        /* not upload image */
        else {
            $file = array("file" => array("name" => $food["image"], "tmp_name" => $food["image"]));
            $builder = new FoodBuilder($data, $file);
        }

        if ($builder->isValid()) {
            $update = $builder->createFood($account);
            $id = $this->menu_db->update($id, $update);
            $this->view->displayModificationSuccess($id);
        } else {
            $this->view->makeModificationPage($id, $builder);
        }
        
    }

    public function saveNewAccount($data) {
        $yourname = $data['yourname'];
        $username = $data['usernameSignUp'];
        $password = $data['passwordSignUp'];
        $confirmPassword = $data['confirmPassword'];

        $username_db = $this->account_db->readUser($username);

        if ($password !== $confirmPassword || $username_db != false || $yourname == '' || $username == '' || $password == '') {
            $this->view->displaySignUpFailure();
        } else {
            $this->account_db->createAccount($data);
            $this->view->displaySignUpSuccessful();
        }

    }

    public function login($data) {
        $username = $data['username'];
        $password = $data['password'];

        $account = $this->account_db->checkAuth($username, $password);

        if ($account != null) {
            return $account;
        }
        else {
            $this->view->displayConnectionFailure();
        }
    }

    public function showAccount() {
        $account = $this->account_db->readAll();
        $this->view->makeAdminPage($account);
    }

    public function showAccountInfo($id) {
        $account = $this->account_db->read($id);
        if ($account != null) {
            $this->view->makeAccountsPage($id, $account);
        } else {
            $this->view->makeUnknownPage();
        }
    }

    public function askDeletionAccount($id) {
        $account = $this->account_db->read($id);
        if ($account != null) {
            $this->view->makeDeletionAccountPage($id, $account);
        } else {
            $this->view->makeUnknownPage();
        }
    }

    public function confirmDeletionAccount($id) {
        $account = $this->account_db->read($id);        
        $delete = $this->account_db->delete($id);
        if (!$delete) {
            $this->view->makeUnknownPage();
        } else {
            $this->view->makeDeletedAccountPage();
        }
    }

}

?>