<?php

require_once("view/View.php");
require_once("view/PrivateView.php");
require_once("control/Controller.php");
require_once("model/MenuStorage.php");
require_once("model/AccountStorage.php");

class Router {
    private $menu_db;
    private $account_db;
    private $account;

    public function __construct(MenuStorage $menu_db, AccountStorage $account_db) {
        $this->menu_db = $menu_db;
        $this->account_db = $account_db;
        $this->account = new Account();
    }

    public function main() {
        session_start();
        $feedback = key_exists('feedback', $_SESSION) ? $_SESSION['feedback'] : '';
		$_SESSION['feedback'] = '';

        if (!key_exists('yourname', $_SESSION)) {
            $view = new View($this, $feedback);
            $ctl = new Controller($view, $this->menu_db, $this->account_db);
        } else {
            if (key_exists('status', $_SESSION))
                $view = new PrivateView($_SESSION['status'], $this, $feedback);

            else
                $view = new PrivateView('', $this, $feedback);

            $ctl = new Controller($view, $this->menu_db, $this->account_db);
        }

        $id = key_exists('id', $_GET) ? $_GET['id'] : null;
        $page = key_exists('page', $_GET) ? $_GET['page'] : null;
        $accId = key_exists('accId', $_GET) ? $_GET['accId'] : null;

        if ($page === null) {
            $page = "homepage";
            if ($id !== null)
                $page = "view";
            else if ($accId !== null)
                $page = "account";
            else 
                $page = "homepage";
        }

		try {
            switch($page) {
                case "gallery":
                    $ctl->showGallery();
                    break;

                case "homepage":
                    if (key_exists('yourname', $_SESSION))
                        $ctl->showHomePage($_SESSION['yourname']);
                    else 
                        $ctl->showHomePage('');
                    break;

                case "create":
                    $ctl->newFood();
                    break;

                case "save":
                    $id = $ctl->saveNewFood($_POST, $_FILES, $_SESSION['username']);    
                    break;
                
                case "delete":
                    if ($id === null)
                        $view->makeUnknownPage();
                    else
                        $ctl->askDeletion($id);
                    break;
                
                case "deleteConfirm":
                    if ($id === null)
                        $view->makeUnknownPage();
                    else
                        $ctl->confirmDeletion($id);
                    break;
                
                case "modify":
                    if ($id === null) 
                        $view->makeUnknownPage();
                    else 
                        $ctl->modifyFood($id);
                    break;

                case "saveModified":
                    if ($id === null) 
                        $view->makeUnknownPage();
                    else 
                        $ctl->saveModified($id, $_POST, $_FILES, $_SESSION['username']);
                    break;

                case "view":
                    if ($id !== null)
                        $ctl->showInformation($id, $_SESSION['username']);
                    else
                       $view->makeUnknownPage();
                    break;
                
                case "login":
                    $view->makeLoginFormPage();
                    break;

                case "connect":
                    $this->account = $ctl->login($_POST);
                    if ($this->account->getUsername() == '') {
                        $view->displayConnectionFailure();
                    } else {
                        $_SESSION['yourname'] = $this->account->getYourName();

                        $_SESSION['status'] = $this->account->getStatus();

                        $_SESSION['username'] = $this->account->getUserName();

                        if ($this->account->getStatus() == 'admin')
                            $view->displayAdminPage();

                        else 
                            $view->displayConnection($_SESSION['yourname']);
                    }

                    break;
                
                case "signup":
                    $view->makeSignUpFormPage();
                    break;

                case "savednewaccount":
                    $ctl->saveNewAccount($_POST);

                case "signout":
                    session_unset();
                    session_destroy();
                    $view->displayConnection('');
                    break;
                
                case "admin":
                    $ctl->showAccount();
                    break;
                
                case "account":
                    if ($accId === null)
                        $view->makeUnknownPage();
                    else
                        $ctl->showAccountInfo($accId);
                    break;

                case "deleteAccount":
                    if ($accId === null)
                        $view->makeUnknownPage();
                    else
                        $ctl->askDeletionAccount($accId);
                    break;
                
                case "deleteAccountConfirm":
                    if ($accId === null)
                        $view->makeUnknownPage();
                    else
                        $ctl->confirmDeletionAccount($accId);
                    break;
                
                case "about":
                    $view->makeAboutPage();
                    break;
            }

		} catch (Exception $e) {
			$view->makeUnknownPage($e);
		}

        $view->render();

    }
    
    public function getHomeURL() {
        return ".";
    }

    public function getGalleryPage() {
        return ".?page=gallery";
    }

    public function getIdURL($id) {
        return ".?id=$id";
    }

    public function getCreationURL() {
        return ".?page=create";
    }

    public function getSaveURL() {
        return "?page=save";
    }

    public function getAskDeletionURL($id) {
		return ".?id=$id&amp;page=deleteConfirm";
    }

    public function getDeletionURL($id) {
		return ".?id=$id&amp;page=delete";
    }

    public function getModifyURL($id) {
        return ".?id=$id&amp;page=modify";
    }

    public function updateModifiedURL($id) {
        return ".?id=$id&amp;page=saveModified";
    }

    public function POSTredirect($url, $feedback) {
        $_SESSION['feedback'] = $feedback;
        header("Location: " . $url, true, 303);
        die;
    }

    public function POSTredirectYourName($url, $yourname) {
        $_SESSION['yourname'] = $yourname;
        header("Location: " . $url, true, 303);
        die;
    }

    public function getLogInURL() {
        return "?page=login";
    }

    public function getSignUpURL() {
        return "?page=signup";
    }

    public function getSavedNewAccount() {
        return "?page=savednewaccount";
    }

    public function getAboutURL() {
        return "?page=about";
    }

    public function getConnectURL() {
        return "?page=connect";
    }

    public function getSignOutURL() {
        return "?page=signout";
    }

    public function getAdminPage() {
        return "?page=admin";
    }

    public function getAccountIdURL($id) {
        return "?accId=$id";
    }

    public function getAskDeletionAccountURL($id) {
		return ".?accId=$id&amp;page=deleteAccountConfirm";
    }

    public function getDeletionAccountURL($id) {
		return ".?accId=$id&amp;page=deleteAccount";
    }

    public function getModifyAccountURL($id) {
        return ".?accId=$id&amp;page=modifyAccount";
    }

    public function updateModifiedAccountURL($id) {
        return ".?accId=$id&amp;page=saveAccountModified";
    }
}

?>