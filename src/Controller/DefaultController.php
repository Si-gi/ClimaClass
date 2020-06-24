<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
class DefaultController extends AbstractController

{

    /**
     * @Route("/", name="homepage")
     */
    public function index() {

        // $videos = $this->parsing($this->__URL);
        if($this->getUser()){
            return $this->redirectToRoute("myclass");
        }
        else{
            return $this->redirectToRoute("fos_user_security_login");
        }

    }

    /**
     * @Route("/search", name="search")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request){
        if(count($_GET) == 0){
            $schools = null;

        }else{
            $school = null;
        }
        return $this->render('search.html.twig', [
            'school' => $school,
        ]);
    }
}