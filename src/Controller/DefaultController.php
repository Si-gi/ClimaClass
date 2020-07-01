<?php


namespace App\Controller;

use App\Entity\School;
use App\Entity\Classroom;
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
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $classRoomRepository;


    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->schoolRepository = $entityManager->getRepository(School::class);
        $this->classRoomRepository = $entityManager->getRepository(Classroom::class);
    }



    /**
     * @Route("/", name="homepage")
     */
    public function index() {

        // $videos = $this->parsing($this->__URL);
        if($this->getUser()){
            return $this->redirectToRoute("publication");
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
            $schools_0 = $this->schoolRepository->findByQuery($_GET['state'],$_GET['city'],$_GET['name'],$_GET['latitude'],$_GET['longitude']);
            if(count($schools_0) > 0){
                $this->addFlash('success', 'résultats trouvés');
                $success = true;

                foreach($schools_0 as $school){
                    $school['classrooms'] = $this->classRoomRepository->findBy(['school' => $school['id']]);
                    $schools_1[] = $school;
                }
            }else{
                $this->addFlash('error', 'No results found');
            }
        }
        return $this->render('search.html.twig', [
            'schools' => $schools_1,
            'success' => $success
        ]);

    }
}
