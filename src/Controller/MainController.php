<?php

namespace App\Controller;

use App\Entity\Post ;
use App\Entity\Review ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    
    public function home()
    {
        $posts = $this->getDoctrine()
        ->getRepository(Post::class)
        ->findAll();


        return $this->render('main/home.html.twig', [
            'posts' => $posts
        ]);
    }

    public function show($id)
    {
        $posts = $this->getDoctrine()
        ->getRepository(Post::class)
        ->find($id);


        return $this->render('main/show.html.twig', [
            'posts' => $posts
        ]);
    }

    public function addReview(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $pseudo = $request->request->get('pseudo');
        $review = $request->request->get('review');
        $id = $request->request->get('post-id');

        $post =$this->getDoctrine()
        ->getRepository(Post::class)
        ->find($id);

        
        $newReview = new Review ;
        $newReview->setUsername($pseudo)  ;
        $newReview->setBody($review)  ;
        $newReview->setPost($post)  ; 

        $entityManager->persist($newReview);

        $entityManager->flush();

        return $this->redirectToRoute('show',  ['id' => $id]);



    }
}
