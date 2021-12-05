<?php

namespace App\Entity;

use App\Entity\CommonTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post
{
    use CommonTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="post_author_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $author;

    /**
     * Default is true. If post is must detemine whether or not publish, use it
     *
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $published;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $subject;

    /**
     * @var json
     *
     * @ORM\Column(type="json", nullable=false)
     */
    private $content;

    /**
     * @var PostCategory
     *
     * @ORM\ManyToOne(targetEntity="PostCategory", inversedBy="posts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category;

    /**
     * @var Userp[]\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinTable(name="post_like_it_user",
     *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    private $likeItUsers;

    /**
     * @var Comment[]\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PostComment", mappedBy="targetPost")
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $comments;

    /**
     * TODO: use it in next version
     * @var PostScript[]|ArrayCollection
     *
     * ORM\OneToMany(targetEntity="PostScript", mappedBy="post")
     * ORM\OrderBy({"createdAt" = "DESC"})
     */
    // private $postscript;

    /**
     * The first time to publish this post, if admin close and republish this post,
     * this field will not be updated.
     * @var \DateTime $publishedAt
     *
     * @ORM\Column(type="datetime", name="published_at", nullable=true)
     */
    private $publishedAt;

    /**
     * Amount of the post readed by user
     * @var int
     *
     * @ORM\Column(name="count_requests", type="integer", options={"default"=0, "unsigned"=true}, nullable=true)
     */
    private $countRequests;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $countComments;

    /**
     * TODO: For the future, I will add data scope, this is the field for data isolation
     */
    private $organization;

    /**
     * @ORM\OneToMany(targetEntity=PostScript::class, mappedBy="post", orphanRemoval=true)
     */
    private $postScripts;

    public function __construct()
    {
        $this->likeItUsers = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->postscript = new ArrayCollection();
        $this->postScripts = new ArrayCollection();
    }

    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of author
     *
     * @return  User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @param  User  $author
     *
     * @return  self
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get default is true. If post is must detemine whether or not publish, use it
     *
     * @return  bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set default is true. If post is must detemine whether or not publish, use it
     *
     * @param  bool  $published  Default is true. If post is must detemine whether or not publish, use it
     *
     * @return  self
     */
    public function setPublished(bool $published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get the value of subject
     *
     * @return  string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set the value of subject
     *
     * @param  string  $subject
     *
     * @return  self
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get the value of content
     *
     * @return  json
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @param  json  $content
     *
     * @return  self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of category
     *
     * @return  PostCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @param  PostCategory  $category
     *
     * @return  self
     */
    public function setCategory(PostCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of likeItUsers
     *
     * @return  Userp[]\ArrayCollection
     */
    public function getLikeItUsers()
    {
        return $this->likeItUsers;
    }

    /**
     * Set the value of likeItUsers
     *
     * @param  Userp[]\ArrayCollection  $likeItUsers
     *
     * @return  self
     */
    public function setLikeItUsers(ArrayCollection $likeItUsers)
    {
        $this->likeItUsers = $likeItUsers;

        return $this;
    }

    /**
     * Get the value of comments
     *
     * @return  Comment[]\ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set the value of comments
     *
     * @param  Comment[]\ArrayCollection  $comments
     *
     * @return  self
     */
    public function setComments(ArrayCollection $comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get the value of postscript
     *
     * @return  PostScript[]|ArrayCollection
     */
    public function getPostscript()
    {
        return $this->postscript;
    }

    /**
     * Set the value of postscript
     *
     * @param  PostScript[]|ArrayCollection  $postscript
     *
     * @return  self
     */
    public function setPostscript($postscript)
    {
        $this->postscript = $postscript;

        return $this;
    }

    /**
     * Get $publishedAt
     *
     * @return  \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Set $publishedAt
     *
     * @param  \DateTime  $publishedAt  $publishedAt
     *
     * @return  self
     */
    public function setPublishedAt(\DateTime$publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get amount of the post readed by user
     *
     * @return  int
     */
    public function getCountRequests()
    {
        return $this->countRequests;
    }

    /**
     * Set amount of the post readed by user
     *
     * @param  int  $countRequests  Amount of the post readed by user
     *
     * @return  self
     */
    public function setCountRequests(int $countRequests)
    {
        $this->countRequests = $countRequests;

        return $this;
    }

    /**
     * Get the value of countComments
     *
     * @return  bool
     */
    public function getCountComments()
    {
        return $this->countComments;
    }

    /**
     * Set the value of countComments
     *
     * @param  bool  $countComments
     *
     * @return  self
     */
    public function setCountComments(bool $countComments)
    {
        $this->countComments = $countComments;

        return $this;
    }

    /**
     * @return Collection|PostScript[]
     */
    public function getPostScripts(): Collection
    {
        return $this->postScripts;
    }

    public function addPostScript(PostScript $postScript): self
    {
        if (!$this->postScripts->contains($postScript)) {
            $this->postScripts[] = $postScript;
            $postScript->setPost($this);
        }

        return $this;
    }

    public function removePostScript(PostScript $postScript): self
    {
        if ($this->postScripts->removeElement($postScript)) {
            // set the owning side to null (unless already changed)
            if ($postScript->getPost() === $this) {
                $postScript->setPost(null);
            }
        }

        return $this;
    }
}
