<?php

namespace App\Repository;

use App\Entity\Love;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @methodLove|null find($id, $lockMode = null, $lockVersion = null)
 * @methodLove|null findOneBy(array $criteria, array $orderBy = null)
 * @methodLove[]    findAll()
 * @methodLove[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Love::class);
    }

    public function isLike( Post $post , User $user){

        $qb = $this->createQueryBuilder('l')
                    ->where('l.post = :post')
                    ->setParameter('post', $post)
                    ->andWhere('l.user = :user')
                    ->setParameter('user', $user)         
                    ->getQuery();
                    
                    

        return $qb->execute() ;



    }

    public function whoLike( $post ){

        $qb = $this->createQueryBuilder('l')
        ->where('l.post = :post')
        ->setParameter('post', $post)                
        ->getQuery();
        
        

        return $qb->execute() ;


    }

    // /**
    //  * @returnLove[] Returns an array ofLove objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Like
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
