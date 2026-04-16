<?php

namespace App\Controller;

use App\Entity\Pokedex;
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

        if ($request->isMethod('POST')) {
            $name = $request->getPayload()->get('name');
            $imageUrl = $request->getPayload()->get('image_url');

            $pokemon = new Pokedex();
            $pokemon->setName($name); 
            $pokemon->setImageUrl($imageUrl); 

            $entityManager->persist($pokemon);
            $entityManager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('poke/add.html.twig', [
            'nombrePokemons' => $nombrePokemons
        ]);
    }
}