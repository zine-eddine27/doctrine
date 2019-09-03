<?php

namespace App\Controller;

use App\Entity\Love;
use App\Entity\User;
use App\Entity\Post ;


use App\Entity\Author ;

use App\Entity\Review ;
use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

        $user = $this->getUser() ;

        $like = new Love() ;

        $isLike = $this->getdoctrine()->getRepository(Love::class)->isLike($post, $user)  ;

        if( !empty($isLike)){

            $ilike = 'liked' ;
            
        } else{

            $ilike= 'noliked' ;
        }

        $whoLike = $this->getdoctrine()->getRepository(Love::class)->whoLike($post)  ;
        
        

        return $this->render('main/show.html.twig', [
            'whoLike'=>$whoLike ,
            'posts' => $post ,
            'like' => $ilike
        ]);
    }

    public function addReview(Request $request)
    {

        
        $entityManager = $this->getDoctrine()->getManager();

        $pseudo = $request->request->get('pseudo');
        $review = $request->request->get('review');
        

        $post =$this->getDoctrine()
        ->getRepository(Post::class)
        ->find($request->request->get('post-id'));

        
        $newReview = new Review ;
        $newReview->setUsername( $this->getUser()->getFirstname() )  ;

        $newReview->setBody($review)  ;
        $newReview->setUser($this->getUser())  ;
        $newReview->setPost($post)  ; 

        $entityManager->persist($newReview);

        $entityManager->flush();

        return $this->redirectToRoute('show',  ['post' => $post->getId() ]);



    }


    public function subscribe(Request $request , ObjectManager $manager , UserPasswordEncoderInterface $encoder)
    {      

        $user = new User() ;

        $form = $this->createForm( RegisterType::class , $user) ;
        
        $form->handleRequest($request) ;

        if( $form->isSubmitted() && $form->isValid()){

            $hash = $encoder->encodePassword($user , $user->getPassword() ) ;

            $user->setPassword($hash) ;

            $manager->persist($user) ;
            $manager->flush() ;

            $this->addFlash('success', 'Votre compte à été créer avec succès. Vous pouvez maintenant vous connecter !');

            return $this->redirectToRoute('login') ;



        }
                
        return $this->render('main/subscribe.html.twig' , 
            [
                'formRegister' => $form->createView() 
            ]);

    }

    public function addPost( Request $request , ObjectManager $manager )
    {
       

        $newPost = new Post() ;

        $form = $this->createFormBuilder($newPost)
                     ->add('title')
                     ->add('body')
                     ->add('image')                     
                     ->getForm() ; 

        $form->handleRequest($request) ;  
        
       
        

        if ( $form->isSubmitted() && $form->isValid() ) { 
            
            $user = $this->getDoctrine()->getRepository(User::class)
            ->find($this->getUser()->getId());
           
            $newPost->setUser($user) ;

            $manager->persist($newPost);          
    
            $manager->flush();

            $this->addFlash('success', 'Votre article "'. $newPost->getTitle() .'" à bien été ajouté.');
           
            return $this->redirectToRoute('home') ;
            
        }

        return $this->render('main/addpost.html.twig',
            [
                
                'formPost' => $form->createView()
            ]) ;
    }



    public function addLike(Post $post , ObjectManager $em){       

        $user = $this->getUser() ;

        $like = new Love() ;

        $isLike = $this->getdoctrine()->getRepository(Love::class)->isLike($post, $user)  ;

        if( !empty($isLike)){
            
            return $this->json(false) ;


        } else{

        $like->setPost($post) ;
        $like->setUser($user) ;

        $likePost =  $post->getNbLike() ;

        $likePost++ ;

        $post->setNbLike($likePost) ;      

        $em->persist($post);
        $em->persist($like);

        $em->flush();

        return $this->json( $post->getNbLike() );
        }

       

    }

    public function login(Request $request){


        return $this->render('main/login.html.twig') ;
    }

    public function logout(){

    }

    
}

