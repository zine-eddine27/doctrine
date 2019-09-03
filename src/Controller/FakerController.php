<?php

namespace App\Controller;

use Faker\Factory;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FakerController extends AbstractController
{
    
    public function addRandomPost(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $user = $this->getDoctrine()->getRepository(User::class)->find(7);
        $post = new Post ;

        $post->setTitle($faker->realText($maxNbChars = 12 , $indexSize = 1)) ;
        $post->setBody($faker->realText($maxNbChars = 500, $indexSize = 2)) ;
        $post->setImage($faker->imageUrl($width = 640, $height = 480)) ;
        $post->setUser($user) ;

        $manager->persist($post) ;
        $manager->flush() ;        

        return $this->redirectToRoute('home') ;


    }
}
