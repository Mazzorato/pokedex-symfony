<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PokeController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $nombrePokemons = 151;   
        return $this->render('poke/index.html.twig',[
        'nombrePokemons' => $nombrePokemons,
        ]);
    }
    #[Route('/add',name:"app_add",methods:["GET","POST"])]
    public function add(): Response
    {
        
        return $this->render('poke/add.html.twig',);
    }
}
