<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/genre/ajouter', name: 'app_genre_ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $genre = new Genre();

        $form = $this->createForm(GenreType::class, $genre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $genre = $form->getData();

            $entityManager->persist($genre);
            $entityManager->flush();

            return $this->redirectToRoute('app_genre');
        }

        return $this->render('genre/ajouter.html.twig', [
            'form' => $form,
        ]);


    }

    #[Route('/genre/modifier/{id}', name: 'app_genre_modifier')]
    public function modifier(Genre $genre, EntityManagerInterface $entityManager, Request $request): Response
    {

        $form = $this->createForm(GenreType::class, $genre);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $genre = $form->getData();

            $entityManager->flush();

            return $this->redirectToRoute('app_genre');
        }

        return $this->render('genre/modifier.html.twig', [
            'form' => $form,
        ]);
    }

}
