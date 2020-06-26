<?php


namespace App\Controller;

use App\Entity\School;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $schoolRepository;


    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->schoolRepository = $entityManager->getRepository(School::class);
    }



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
        $success = false;
        if(count($_GET) == 0){
            $schools = null;

        }else{
            $schools = $this->schoolRepository->findByQuery($_GET['state'],$_GET['city'],$_GET['name'],$_GET['latitude'],$_GET['longitude']);
            if(count($schools) > 0){
                $this->addFlash('success', 'résultats trouvés');
            }else{
                $this->addFlash('error', 'No results found');
            }
        }
        return $this->render('search.html.twig', [
            'schools' => $schools,
            'success' => $success
        ]);
    }
}