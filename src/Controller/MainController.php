<?php

namespace App\Controller;

use App\Entity\Author ;
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

    public function show(Post $post)
    {
        


        return $this->render('main/show.html.twig', [
            'posts' => $post
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

        return $this->redirectToRoute('show',  ['post' => $id]);



    }

    public function listAuthors()
    {

        $authors = $this->getDoctrine()
        ->getRepository(Author::class)
        ->findAll();

        
        return $this->render('main/author.html.twig', [
            'authors' => $authors
        ]);


    }

    public function subscribe(Request $request)
    {

       
                
        return $this->render('main/subscribe.html.twig');


    }


    public function addAuthor(Request $request)
    {

        $firstname = $request->request->get('prenom');
        $lastname= $request->request->get('nom');
                
        $newAuthor = new Author ;
        $newAuthor->setFirstname($firstname)  ;
        $newAuthor->setLastname($lastname)  ;       

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($newAuthor);

        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    public function addPost()
    {
        $authors = $this->getDoctrine()
        ->getRepository(Author::class)
        ->findAll();


        return $this->render('main/addpost.html.twig',
            [
                'authors' => $authors
            ]) ;
    }

    public function addPostForm(Request $request, Author $author)
    {

        dump($request); exit ;
    }

}
