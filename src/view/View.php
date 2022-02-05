<?php

class View {
    protected $router;
    protected $title;
    protected $content;
    protected $feedback;

    public function __construct(Router $router, $feedback) {
		$this->router = $router;
		$this->title = null;
		$this->content = null;
        $this->feedback = $feedback;
	}

    public function render() {
        if ($this->title === null || $this->content === null) {
			$this->makeUnknownPage();
		}

		$title = $this->title;
		$content = $this->content;
        $menu = array(
            "Accueil" => $this->router->getHomeURL(),
            "Galerie" => $this->router->getGalleryPage(),
            "À propos" =>$this->router->getAboutURL(),
            "Se connecter" =>$this->router->getLogInUrl(),
            "S'inscrire" =>$this->router->getSignUpURL(),
        );
        
		include("template.php");
    }

    public function makeHome($yourname) {
        $this->title = "Bienvenue " .$yourname." !";
        $this->content = "Site des plats";
    }

    public function makeHomePage($food, $yourname) {
        $this->title = "Bienvenue " .$yourname." !";
        $name = $food['name'];
        $file = $food['image'];

        $text = "<div class='info'>";
		$text .= "<h2>Plat du jour</h2>";
        $text .= "<h3>".$name."</h3>";
		$text .= "</div>";

        if ($file != null) 
            $text .= '<img src=src/upload/' . $file. ' alt >';
        else 
            $text .= "";   
        
        $this->content .= $text;
    }
    
    public function galleryPage($id, $food) {
        $content = "<div class='info'>";
        $content .= '<h2>' . $food['name'] . '</h2>';
		$content .= "<div class='info'>";
        return $content;
    }

    public function makeFoodPage($id, $food, $username) {
		$name = $food['name'];
        $description = $food['description'];
        $type = $food['type'];
        $origin = $food['origin'];
        $image = $food['image'];
        $account = $food['account'];

        $this->title = $name;
        $text = "<div class='info'>";
        $text .= "<h2>".$type."</h2>";
        $text .= "<p>".$description."</p>";
        $text .= "<p>Origine : " . $origin."</p>"; 
        $text .= "<p>Créateur : " . $account ."</p>"; 
		$text .= "</div>";

        if ($image != null) 
            $text .= '<img src=src/upload/' . $image. ' alt >';
        else 
            $text .= "";   

        $text .= '<ul class="button">';

        if ($account == $username || $username == "admin") {
            $text .= '<li><a href="'.$this->router->getModifyURL($id).'">Modifier</a></li>'."\n";
            $text .= '<li><a href="'.$this->router->getDeletionURL($id).'">Supprimer</a></li>'."\n";
        }

        $text .= '<li><a href="'.$this->router->getGalleryPage().'">Retour</a></li>'."\n";
        $text .= '</ul>';
        $this->content = $text;
    }

    public function makeUnknownPage() {
        $this->title = "Erreur";
		$this->content = "Une erreur inattendue s'est produite.";
    }

    public function makeDebugPage($variable) {
        $this->title = 'Debug';
        $this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
    }

    public function makeGalleryPage($menu) {
        $this->title = "Menu";
        $this->content .= "<ul class=\"gallery\">\n";
		foreach ($menu as $id => $obj) {
			$this->content .= $this->galleryPage($obj['id'], $obj);
		}
		$this->content .= "</ul>\n";
    }

    public function makeCreationPage(FoodBuilder $builder) {
        $this->title = "Ajouter votre plat";
		$form = '<form enctype="multipart/form-data" action="'.$this->router->getSaveURL().'" method="POST">'."\n";
        $form .= self::getFormFields($builder);
        $form .= "<ul class='button'>";
        $form .= "<li><button>Créer</button></li>";
        $form .= '<li><a href="'.$this->router->getGalleryPage().'">Retour</a></li>';
        $form .= "</ul>";
        $form .= "</form>\n";
		$this->content = $form;
    }

    public function makeModificationPage($id, FoodBuilder $builder) {
        $this->title = "Modifer le plat";
		$form = '<form enctype="multipart/form-data" action="'.$this->router->updateModifiedURL($id).'" method="POST">'."\n";
        $form .= self::getFormFields($builder);
        $form .= "<ul class='button'>";
        $form .= "<li><button>Modifier</button></li>";
        $form .= '<li><a href="'.$this->router->getIdURL($id).'">Annuler</a></li>';
        $form .= "</ul>";
        $form .= "</form>\n";
		$this->content = $form;
    }

    public function displayModificationSuccess($id) {
		$this->router->POSTredirect($this->router->getIdURL($id), "Le plat a bien été modifié !");
	}

    public function makeDeletionPage($id, $food) {
        $name = $food['name'];
		$this->title = "Suppression $name";
		$this->content .= "<p class='deleteText'>« {$name} » va être supprimée.</p>\n";
		$this->content .= '<form action="'.$this->router->getAskDeletionURL($id).'" method="POST">'."\n";
		$this->content .= "<button>Confirmer</button>\n</form>\n";
    }

    public function makeDeletedPage() {
        $this->router->POSTredirect($this->router->getGalleryPage(), "Le plat a bien été supprimé !");
    }

    public function displayCreationSuccess($id) {
        $this->router->POSTredirect($this->router->getIdURL($id), "Le plat a bien été créé !");
    }

    public function getFormFields(FoodBuilder $builder) {
        $form = '<input type="text" placeholder="Nom du plat" name="name"' .  ' value="' . $builder->getData("name") . '"/>';
        $err = $builder->getErrors("name");
		if ($err !== null)
			$form .= ' <span class="error">'.$err.'</span><br>';

        $form .= '<input type="text" placeholder="Description" name="description"' .  ' value="' . $builder->getData("description") . '"/>';
        $err = $builder->getErrors("description");
		if ($err !== null)
			$form .= ' <span class="error">'.$err.'</span><br>';
        
        $form .= '<input type="text" placeholder="Type" name="type"' .  ' value="' . $builder->getData("type") . '"/>';
        $err = $builder->getErrors("type");
		if ($err !== null)
			$form .= ' <span class="error">'.$err.'</span><br>';
        
        $form .= '<input type="text" placeholder="Origine" name="origin"' .  ' value="' . $builder->getData("origin") . '"/>';
        $err = $builder->getErrors("origin");
        if ($err !== null)
            $form .= ' <span class="error">'.$err.'</span>';
            
        $form .= '<h1 class="upload">Choisir une image</h1>';
		$form .= '<input type="file" name="file">';
        $err = $builder->getErrors("file");
        if ($err !== null)
            $form .= ' <span class="error">'.$err.'</span><br>';

        if ($builder->getFile() !== "")
            $form .= '<img src=src/upload/' . $builder->getFile() . ' alt >';
        else 
            $form .= '';
    
        return $form;
    }

    public function makeLoginFormPage() {
        $this->title = "Connexion";
		$form = '<form action="'.$this->router->getConnectURL().'" method="POST">'."\n";
        $form .= '<input type="text" placeholder="Username" name="username"/>';
        $form .= '<input type="password" placeholder="Password" name="password"/>';
        $form .= "<ul class='button'>";
        $form .= "<li><button>Connexion</button></li>";
        $form .= "</ul>";
        $form .= "</form>\n";
        $this->content = $form;
    }

    public function makeSignUpFormPage() {
        $this->title = "Inscription";
		$form = '<form action="'.$this->router->getSavedNewAccount().'" method="POST">'."\n";
        $form .= '<input type="text" placeholder="Your Name" name="yourname"/>';
        $form .= '<input type="text" placeholder="Username" name="usernameSignUp"/>';
        $form .= '<input type="password" placeholder="Password" name="passwordSignUp"/>';
        $form .= '<input type="password" placeholder="Confirm Password" name="confirmPassword"/>';
        $form .= "<ul class='button'>";
        $form .= "<li><button>S'inscrire</button></li>";
        $form .= "</ul>";
        $form .= "</form>\n";
        $this->content = $form;
    }

    public function displayConnection($yourname) {
		$this->router->POSTredirectYourName($this->router->getHomeURL(), $yourname);
	}

    public function displaySignUpSuccessful() {
        $this->router->POSTredirect($this->router->getSignUpURL(), "Le compte est bien créé !");
    }
    
    public function displaySignUpFailure() {
        $this->router->POSTredirect($this->router->getSignUpURL(), "Le compte ne peut pas être créé, vérifiez vos entrées ou choisissez un autre username");
    }

    public function displayConnectionFailure() {
        $this->router->POSTredirect($this->router->getLogInURL(), "Le compte n'existe pas !");
    }

    public function setAccount($account) {
        return new Account($account["yourname"], $account["username"], $account["password"], $account["status"]);
    }

    public function makeAdminPage($account_db) {
        $this->title = "Page d'administrateur";
        $this->content .= "<ul class=\"gallery\">\n";
		foreach ($account_db as $id => $obj) {
            if ($obj['status'] != "admin")
                $this->content .= $this->accountPage($obj['id'], $obj);
		}
		$this->content .= "</ul>\n";
    }

    public function accountPage($id, $account) {
        $content = '<li><a href="'.$this->router->getAccountIdURL($id).'">';
        $content .= '<h3>' . $account['yourname'] . '</h3>';
		$content .= '</a></li>'."\n";
        return $content;
    }

    public function makeAccountsPage($id, $account) {
		$yourname = $account['yourname'];
        $username = $account['username'];

        $this->title = $yourname;
        $text = "<div class='info'>";
        $text .= "<h2>Username : ".$username."</h2>";
		$text .= "</div>";

        $text .= '<ul class="button">';
        $text .= '<li><a href="'.$this->router->getDeletionAccountURL($id).'">Supprimer</a></li>'."\n";
        $text .= '<li><a href="'.$this->router->getAdminPage().'">Retour</a></li>'."\n";
        $text .= '</ul>';
        $this->content = $text;
    }

    public function displayAdminPage() {
        header("Location: " . $this->router->getAdminPage(), true, 303);
        die;
    }

    public function makeDeletionAccountPage($id, $account) {
        $name = $account['yourname'];
		$this->title = "Suppression $name";
		$this->content .= "<p class='deleteText'>« {$name} » va être supprimée.</p>\n";
		$this->content .= '<form action="'.$this->router->getAskDeletionAccountURL($id).'" method="POST">'."\n";
		$this->content .= "<button>Confirmer</button>\n</form>\n";
    }

    public function makeDeletedAccountPage() {
        $this->router->POSTredirect($this->router->getAdminPage(), "Le compte à bien été supprimé !");
    }

    public function makeAboutPage() {
        $this->title = "À propos";
        $text = "<div class='info'>";
		$text .= "<h2>Groupe 24 - TP 4A</h2>";
		$text .= "<p>21911658</p>";
		$text .= "<p>21716001</p>";
        $text .= "<h2>Compléments réalisés</h2>";
        $text .= "<ul style='list-style-type: none'>";
        $text .= "<li>Un objet peut être illustré par une image uploadée par le créateur de l'objet.</li>";
        $text .= "<li>Site responsive.</li>";
        $text .= "<li>Gestion par un admin des comptes utilisateurs.</li>";
        $text .= "</ul>";
		$text .= "<h2>Répartition des tâches</h2>";
		$text .= "<p>21911658 : Inspiration des TP pour le PHP. Création du design en CSS. Création de partie objet, authentification avec la base de donnée et des compléments.</p>";
		$text .= "<p>21716001 : Création de partie authentification avec la base de donnée et des compléments.</p>";
		$text .= "<h2>Informations supplémentaires</h2>";
		$text .= "<p>Un objet ne peut être illustré que par une image mais peut être modifiée.";
		$text .= "<p>L'administrateur peut supprimer les comptes utilisateurs mais ne peut pas les modifier.";
		$text .= "<h2>Principaux choix en matière de design</h2>";
		$text .= "<p>Inspiration du design de dashboard.</p>";

		$text .= "</div>";
        $this->content = $text;
    }


}


?>
