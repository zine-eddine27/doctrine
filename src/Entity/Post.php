<?php

namespace App\Entity;

use App\Entity\Review ;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
    */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbLike;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updtaedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="post")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="post")
     */
    private $review;

    public function __construct()
    {
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

    public function getUpdtaedAt(): ?\DateTimeInterface
    {
        return $this->updtaedAt;
    }

    public function setUpdtaedAt(\DateTimeInterface $updtaedAt): self
    {
        $this->updtaedAt = $updtaedAt;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

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
}
