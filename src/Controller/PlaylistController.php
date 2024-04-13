<?php

namespace App\Controller;
use App\Form\PlaylistType;
use App\Entity\Playlist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PlaylistRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class PlaylistController extends AbstractController
{
    #[Route('/playlists', name: 'playlist.index' , requirements : ['id'=> '\d+' , 'slug'=>'[a-z0-9-]+'])]
    public function index(Request $request , PlaylistRepository $repository): Response
    {
        $playlists =$repository->findAll();
        
        return $this->render('playlist/index.html.twig' , [
            'playlists' => $playlists
            ]
    );
    }



    #[Route('/playlists/{slug}-{id}', name: 'playlist.show' , requirements : ['id'=> '\d+' , 'slug'=>'[a-z0-9-]+'])]
    public function show(Request $request, string $slug , int $id , PlaylistRepository $repository): Response
    {
        $playlist=$repository->find($id);
       if ($playlist->getSlug() != $slug) {
            return $this->redirectToRoute('playlist.show' , ['slug'=>$playlist->getSlug() , 'id'=>$playlist->getId()]);
       }
        return $this->render('playlist/show.html.twig', [
            'playlist'=>$playlist
        ]);
    }

    #[Route('/playlists/{id}/edit' , name: 'playlist.edit')]
    public function edit(Playlist $playlist, Request $request , EntityManagerInterface $em) {
        $form=$this->createForm(PlaylistType::class , $playlist);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success' , 'La recette a bien été modifiée');
            return $this->redirectToRoute('playlist.index');
        }
        return $this->render('playlist/edit.html.twig', [
            'playlist'=>$playlist,
            'form'=>$form
        ]);
    }
}
