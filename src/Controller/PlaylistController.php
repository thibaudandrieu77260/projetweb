<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class PlaylistController extends AbstractController
{
    #[Route('/playlist', name: 'playlist.index' , requirements : ['id'=> '\d+' , 'slug'=>'[a-z0-9-]+'])]
    public function index(Request $request): Response
    {
        return $this->render('playlist/index.html.twig');
    }



    #[Route('/playlist/{slug}-{id}', name: 'playlist.show' , requirements : ['id'=> '\d+' , 'slug'=>'[a-z0-9-]+'])]
    public function show(Request $request, string $slug , int $id): Response
    {
        return $this->render('playlist/show.html.twig', [
            'slug'=> $slug,
            'id'=> $id
        ]);
    }
}
