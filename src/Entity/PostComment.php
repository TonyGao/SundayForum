<?php

namespace App\Entity;

use App\Repository\PostCommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostCommentRepository::class)
 */
class PostComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="postComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="json")
     */
    private $content = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $diggit;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $diggUsers = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nagative;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $negativeUsers = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getContent(): ?array
    {
        return $this->content;
    }

    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDiggit(): ?int
    {
        return $this->diggit;
    }

    public function setDiggit(?int $diggit): self
    {
        $this->diggit = $diggit;

        return $this;
    }

    public function getDiggUsers(): ?array
    {
        return $this->diggUsers;
    }

    public function setDiggUsers(?array $diggUsers): self
    {
        $this->diggUsers = $diggUsers;

        return $this;
    }

    public function getNagative(): ?int
    {
        return $this->nagative;
    }

    public function setNagative(?int $nagative): self
    {
        $this->nagative = $nagative;

        return $this;
    }

    public function getNegativeUsers(): ?array
    {
        return $this->negativeUsers;
    }

    public function setNegativeUsers(?array $negativeUsers): self
    {
        $this->negativeUsers = $negativeUsers;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }
}
