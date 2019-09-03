<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * 
    */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(
     *      min = 6,
     *      max = 100,
     *      minMessage = "Le titre de votre post doit contenir minimum {{ limit }} charactères.",
     *      maxMessage = "Le titre de votre post doit contenir maximum {{ limit }} charactères."
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * 
     */
    private $body;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(
     *    checkDNS = "ANY" ,
     *    protocols = {"http", "https", "ftp"} , 
     *    message = "l'url '{{ value }}' n 'est pas une URL valide.",
     * )
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbLike = 0 ;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * 
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

  

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="post")
     * 
     */
    private $review;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="post")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {

        $this->nbLike = 0 ;
        $this->createdAt = new \DateTime();
        $this->review = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getNbLike(): ?int
    {
        return $this->nbLike;
    }

    public function setNbLike(int $nbLike): self
    {
        $this->nbLike = $nbLike;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

 

    /**
     * @return Collection|review[]
     */
    public function getReview(): Collection
    {
        return $this->review;
    }

    public function addReview(review $review): self
    {
        if (!$this->review->contains($review)) {
            $this->review[] = $review;
            $review->setPost($this);
        }

        return $this;
    }

    public function removeReview(review $review): self
    {
        if ($this->review->contains($review)) {
            $this->review->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getPost() === $this) {
                $review->setPost(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
