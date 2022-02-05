<?php

require_once("view/View.php");

class PrivateView extends View {

    protected $session;

    public function __construct($session, Router $router, $feedback) {
        parent::__construct($router, $feedback);
        $this->session = $session;
    }

    public function render() {
        if ($this->title === null || $this->content === null) {
			$this->makeUnknownPage();
		}

		$title = $this->title;
		$content = $this->content;

        if ($this->session == "admin") {
            $menu = array(
                "Accueil" => $this->router->getHomeURL(),
                "Galerie" => $this->router->getGalleryPage(),
                "Nouveau plat" => $this->router->getCreationURL(),
                "Administration" => $this->router->getAdminPage(),
                "À propos" =>$this->router->getAboutURL(),
                "Se déconnecter" =>$this->router->getSignOutUrl(),
            );
        } else {
            $menu = array(
                "Accueil" => $this->router->getHomeURL(),
                "Galerie" => $this->router->getGalleryPage(),
                "Nouveau plat" => $this->router->getCreationURL(),
                "À propos" =>$this->router->getAboutURL(),
                "Se déconnecter" =>$this->router->getSignOutUrl(),
            );
        }

        
		include("template.php");
    }

    public function galleryPage($id, $food) {
        $content = '<li><a href="'.$this->router->getIdURL($id).'">';
        $content .= '<h3>' . $food['name'] . '</h3>';
		$content .= '</a></li>'."\n";
        return $content;
    }



}



?>