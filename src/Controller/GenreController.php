<?php

namespace App\Controller;

use App\Entity\Genre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    #[Route('/genre', name: 'app_genre')]
    public function liste(EntityManagerInterface $entityManager): Response
    {

        $repository = $entityManager->getRepository(Genre::class);

        $genres = $repository->findAll();


        return $this->render('genre/index.html.twig', [
            'genres' => $genres,
        ]);
    }


}
