<?php


namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{

    /**
     * @Route("/homepage", name="homepage")
     */
    public function index() {

        // $videos = $this->parsing($this->__URL);
        if($this->getUser()){
            return $this->redirectToRoute("articles");
        }
        else{
            return $this->redirectToRoute("fos_user_security_login");
        }

    }
}