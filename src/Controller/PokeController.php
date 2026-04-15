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
         
        return $this->render('poke/index.html.twig',[
        'nombrePokemons' => count($pokemons),
        'pokemons' =>$pokemons,
        ]);
    }
    #[Route('/add',name:"app_add",methods:["GET","POST"])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response    {
        // if ($request->isMethod('Post')){
            // $name = $request->getPayload()->get('name');
            // $imageUrl = $request->getPayload()->get('image_url');

        $pokemon = new Pokedex();
        $pokemon->setName("booba");
        $pokemon->setImageUrl("http://unsplash.it/100/100");

        $entityManager->persist($pokemon);
        $entityManager->flush();
        // }
        return $this->render('poke/add.html.twig',[
        
        ]);
    }
}
