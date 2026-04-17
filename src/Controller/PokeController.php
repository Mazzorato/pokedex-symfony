<?php

namespace App\Controller;

use App\Entity\Pokedex;
use App\Form\PokedexType;
use App\Repository\PokedexRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PokeController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(PokedexRepository $pokedexRepository): Response
    {
        $pokemons = $pokedexRepository->findAll();
         
        return $this->render('poke/index.html.twig', [
            'nombrePokemons' => count($pokemons),
            'pokemons' => $pokemons,
        ]);
    }


    #[Route('/add', name: "app_add", methods: ["GET", "POST"])]
    public function add(Request $request, EntityManagerInterface $entityManager, PokedexRepository $pokedexRepository): Response 
    {
        $pokemons = $pokedexRepository->findAll();
        $nombrePokemons = count($pokemons);

        $pokemon = new Pokedex();
        $form = $this->createForm(PokedexType::class, $pokemon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pokemon);
            $entityManager->flush();

            return $this->redirectToRoute('app_index');
        }
        return $this->render('poke/add.html.twig', [
            'form' => $form,
            'nombrePokemons' => $nombrePokemons
        ]);
       
    
    }
}