<?php

namespace App\Controller;

use App\Entity\Chanson;
use App\Entity\Genre;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

use function Symfony\Component\Clock\now;

class ChansonController extends AbstractController
{
    //Route qui mène à la liste de mes chansons (home)
    #[Route('/', name: 'app_chanson')]
    public function liste(EntityManagerInterface $entityManager): Response
    {

        $repository = $entityManager->getRepository(Chanson::class);

        $chansons = $repository->findAll();


        return $this->render('chanson/index.html.twig', [
            'chansons' => $chansons,
        ]);
    }

    #[Route('/chanson/detail/{id}', name: 'app_chanson_detail')]
    public function detail(Chanson $chanson): Response
    {

        return $this->render('chanson/detail.html.twig', [
            'chanson' => $chanson,
        ]);
    }



    //Création d'une chanson via une route (sans formulaire)
    #[Route('/chanson/ajouter', name: 'app_article_ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chanson = new chanson();

        //$chanson->setDateAjout();

        $form = $this->createForm(ChansonType::class, $chanson);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $chanson = $form->getData();

            $entityManager->persist($chanson);
            $entityManager->flush();

            return $this->redirectToRoute('app_chanson');
        }

        return $this->render('chanson/ajouter.html.twig', [
            'form' => $form,
        ]);
    }

}
