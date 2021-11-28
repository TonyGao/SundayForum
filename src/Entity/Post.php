<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\CommonTrait;
use Doctrine\Common\Collections\ArrayCollection;

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
     *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id"), onDelete="CASCADE"}
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
     * @var PostScript[]|ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="PostScript", mappedBy="post")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $postscript;

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

    public function __construct()
    {
        $this->likeItUsers = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->postscript = new ArrayCollection();
    }
}